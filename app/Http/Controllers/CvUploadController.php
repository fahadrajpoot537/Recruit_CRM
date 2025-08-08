<?php

namespace App\Http\Controllers;

use App\Models\ParsedCv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Exception;
use Illuminate\Support\Facades\Log;

class CvUploadController extends Controller
{
    
    private $fieldLimits = [
        'candidate_name' => 200,
        'candidate_first_name' => 100,
        'candidate_last_name' => 100,
        'phone_number' => 50,
        'email' => 100,
        'address_line_1' => 255,
        'area' => 100,
        'city' => 100,
        'partial_post_code' => 20,
        'full_post_code' => 20,
        'nationality' => 100,
        'languages_spoken' => 500,
        'summary' => 2000,
        'current_organization' => 200,
        'position_title' => 200,
        'total_experience' => 50,
    ];

    public function index()
    {
        return view('cv.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cv_files' => 'required',
            'cv_files.*' => 'file|mimes:pdf,docx,doc,jpg,jpeg,png|max:10240'
        ]);

        $results = [];
        $errors = [];

        $files = $request->file('cv_files');
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            try {
                $result = $this->processSingleCV($file);
                $results[] = $result;
            } catch (Exception $e) {
                Log::error('CV Upload Error for file ' . $file->getClientOriginalName() . ': ' . $e->getMessage());
                $errors[] = [
                    'file' => $file->getClientOriginalName(),
                    'error' => $e->getMessage()
                ];
            }
        }

        return view('cv.parsed', compact('results', 'errors'));
    }

    private function processSingleCV($file)
    {
        $path = $file->store('uploads/cvs', 'public');
        
        // Parse the content
        $text = $this->parseFileEnhanced($file);
        
        // Extract fields with improved logic
        $fields = $this->extractFieldsEnhanced($text);

        // Validate and truncate fields to prevent database errors
        $fields = $this->validateAndTruncateFields($fields);

        // Create parsed CV record
        $cv = ParsedCv::create([
            'candidate_ref' => $this->generateCandidateRef(),
            'cv_folder' => 'uploads/cvs',
            'opt_out' => false,
            'agent' => null,
            'date' => now(),
            'source' => 'CV Upload',
            'candidate_name' => $fields['candidate_name'],
            'candidate_first_name' => $fields['first_name'],
            'candidate_last_name' => $fields['last_name'],
            'phone_number' => $fields['contact_number'],
            'email' => $fields['email'],
            'address_line_1' => $fields['address_line_1'],
            'area' => $fields['area'],
            'city' => $fields['city'],
            'partial_post_code' => $fields['partial_post_code'],
            'full_post_code' => $fields['full_post_code'],
            'nationality' => $fields['nationality'],
            'gender' => $fields['gender'],
            'dob' => $fields['dob'],
            'age' => $fields['age'],
            'right_to_work' => $fields['right_to_work'],
            'driving_licence' => $fields['driving_license'],
            'languages_spoken' => $fields['languages_spoken'],
            'summary' => $fields['summary'],
            'skills' => json_encode($fields['skills'] ?? []),
            'experience' => json_encode($fields['experience'] ?? []),
            'education' => json_encode($fields['education'] ?? []),
            'certifications' => json_encode($fields['certifications'] ?? []),
            'linkedin' => $fields['linkedin'],
            'github' => $fields['github'],
            'current_organization' => $fields['current_organization'],
            'position_title' => $fields['position_title'],
            'total_experience' => $fields['total_experience'],
            'current_salary' => $fields['current_salary'],
            'salary_expectation' => $fields['salary_expectation'],
            'notice_period_days' => $fields['notice_period_days'],
            'available_from' => $fields['available_from'],
            'willing_to_relocate' => $fields['willing_to_relocate'],
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'parsed_fields' => $fields,
        ]);

        return [
            'cv' => $cv,
            'fields' => $fields,
            'file_name' => $file->getClientOriginalName()
        ];
    }

    private function generateCandidateRef()
    {
        return 'CV' . date('Ymd') . rand(1000, 9999);
    }

    private function parseFileEnhanced($file)
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $text = '';

        try {
            switch ($ext) {
                case 'pdf':
                    $text = $this->parsePDF($file);
                    break;
                case 'docx':
                case 'doc':
                    $text = $this->parseWord($file);
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                    $text = $this->parseImage($file);
                    break;
            }

            return $this->cleanText($text);

        } catch (Exception $e) {
            Log::error('File parsing error: ' . $e->getMessage());
            throw new Exception('Failed to parse file: ' . $e->getMessage());
        }
    }

    private function parsePDF($file)
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $pdf->getText();
            
            if (strlen(trim($text)) < 50) {
                Log::info('PDF text extraction minimal, attempting OCR');
                $text = $this->parseImage($file);
            }
            
            return $text;
        } catch (Exception $e) {
            Log::warning('PDF parsing failed, attempting OCR: ' . $e->getMessage());
            return $this->parseImage($file);
        }
    }

    private function parseWord($file)
    {
        $text = '';
        $phpWord = IOFactory::load($file->getPathname());

        foreach ($phpWord->getSections() as $section) {
            $elements = $section->getElements();
            foreach ($elements as $element) {
                $text .= $this->extractTextFromElement($element) . "\n";
            }
        }

        return $text;
    }

    private function extractTextFromElement($element)
    {
        $text = '';
        
        if (method_exists($element, 'getElements')) {
            foreach ($element->getElements() as $childElement) {
                $text .= $this->extractTextFromElement($childElement);
            }
        } elseif (method_exists($element, 'getText')) {
            $text .= $element->getText() . ' ';
        } elseif (method_exists($element, 'getRows')) {
            foreach ($element->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    foreach ($cell->getElements() as $cellElement) {
                        $text .= $this->extractTextFromElement($cellElement) . ' ';
                    }
                }
                $text .= "\n";
            }
        }

        return $text;
    }

    private function parseImage($file)
    {
        try {
            $ocr = new TesseractOCR($file->getPathname());
            $ocr->lang('eng')
                ->configFile('pdf')
                ->option('preserve_interword_spaces', 1)
                ->option('tessedit_pageseg_mode', 1);
            
            $text = $ocr->run();
            
            if (strlen(trim($text)) < 20) {
                $ocr->option('tessedit_pageseg_mode', 6);
                $text = $ocr->run();
            }

            return $text;
            
        } catch (Exception $e) {
            Log::error('OCR failed: ' . $e->getMessage());
            throw new Exception('Image text extraction failed.');
        }
    }

    private function cleanText($text)
    {
        if (empty($text)) {
            return '';
        }

        // Remove control characters but preserve line breaks
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $text);
        
        // Fix encoding issues
        if (!mb_check_encoding($text, 'UTF-8')) {
            $encoding = mb_detect_encoding($text, ['UTF-8', 'ISO-8859-1', 'Windows-1252', 'ASCII'], true);
            if ($encoding && $encoding !== 'UTF-8') {
                $text = mb_convert_encoding($text, 'UTF-8', $encoding);
            } else {
                $text = utf8_encode($text);
            }
        }

        // Normalize whitespace while preserving structure
        $text = preg_replace('/\r\n?/', "\n", $text);
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        
        return trim($text);
    }

    private function extractFieldsEnhanced($text)
    {
        $fields = [
            'first_name' => null,
            'last_name' => null,
            'candidate_name' => null,
            'email' => null,
            'contact_number' => null,
            'address_line_1' => null,
            'area' => null,
            'city' => null,
            'partial_post_code' => null,
            'full_post_code' => null,
            'nationality' => null,
            'gender' => null,
            'dob' => null,
            'age' => null,
            'right_to_work' => false,
            'driving_license' => false,
            'languages_spoken' => null,
            'summary' => null,
            'skills' => [],
            'experience' => [],
            'education' => [],
            'certifications' => [],
            'linkedin' => null,
            'github' => null,
            'current_organization' => null,
            'position_title' => null,
            'total_experience' => null,
            'current_salary' => null,
            'salary_expectation' => null,
            'notice_period_days' => null,
            'available_from' => null,
            'willing_to_relocate' => false,
        ];

        $lines = explode("\n", $text);
        $textLower = strtolower($text);

        // Extract basic information
        $fields = $this->extractBasicInfo($fields, $lines, $text, $textLower);
        
        // Extract sections (skills, experience, education)
        $fields = $this->extractSections($fields, $text, $textLower, $lines);
        
        // Extract professional information
        $fields = $this->extractProfessionalInfo($fields, $text, $textLower);

        // Set candidate_name
        if ($fields['first_name'] && $fields['last_name']) {
            $fields['candidate_name'] = trim($fields['first_name'] . ' ' . $fields['last_name']);
        }

        return $fields;
    }

    private function extractBasicInfo($fields, $lines, $text, $textLower)
    {
        // Extract Email
        if (preg_match('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/i', $text, $match)) {
            $fields['email'] = trim($match[1]);
        }

        // Extract Phone Number
        $phonePatterns = [
            '/(\+92[\s\-]?\d{3}[\s\-]?\d{7})/',
            '/(03\d{9})/',
            '/(\+44[\s\-]?\d{4}[\s\-]?\d{6})/',
            '/(07\d{9})/',
            '/(\+\d{1,4}[\s\-]?\d{3,4}[\s\-]?\d{6,10})/'
        ];
        
        foreach ($phonePatterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                $fields['contact_number'] = $match[1];
                break;
            }
        }

        // Extract Name - Improved
        $fields = $this->extractName($fields, $lines, $text);

        // Extract Address
        $fields = $this->extractAddress($fields, $text);

        // Extract Personal Details
        $fields = $this->extractPersonalDetails($fields, $text, $textLower);

        return $fields;
    }

    private function extractName($fields, $lines, $text)
    {
        // Method 1: Look for ALL CAPS names (like FAHAD BIN KHALID, LINDSEY OYINLOYE)
        if (preg_match('/^([A-Z][A-Z\s]{4,50})$/m', $text, $match)) {
            $name = trim($match[1]);
            if (!preg_match('/\d|@|\.com|email|phone|contact|profile/i', $name)) {
                $parts = preg_split('/\s+/', $name);
                if (count($parts) >= 2 && count($parts) <= 4) {
                    $fields['first_name'] = $parts[0];
                    $fields['last_name'] = implode(' ', array_slice($parts, 1));
                    return $fields;
                }
            }
        }

        // Method 2: Look in first 5 lines for name patterns
        for ($i = 0; $i < min(5, count($lines)); $i++) {
            $line = trim($lines[$i]);
            
            // Skip obvious non-name lines
            if (empty($line) || strlen($line) < 4 || strlen($line) > 50) continue;
            if (preg_match('/@|www\.|http|\.com|\+?\d{3,}|contact|email|phone|profile|portfolio/i', $line)) continue;
            
            // Look for name patterns
            if (preg_match('/^[A-Za-z\s\.]{4,50}$/', $line)) {
                $parts = preg_split('/\s+/', $line);
                
                if (count($parts) >= 2 && count($parts) <= 4) {
                    $validName = true;
                    foreach ($parts as $part) {
                        if (strlen($part) < 2 || !preg_match('/^[A-Za-z\.]+$/', $part)) {
                            $validName = false;
                            break;
                        }
                    }
                    
                    if ($validName) {
                        $fields['first_name'] = $parts[0];
                        $fields['last_name'] = implode(' ', array_slice($parts, 1));
                        break;
                    }
                }
            }
        }

        return $fields;
    }

    private function extractAddress($fields, $text)
    {
        // UK Postcode
        if (preg_match('/\b([A-Z]{1,2}\d{1,2}[A-Z]?\s?\d[A-Z]{2})\b/', $text, $match)) {
            $fields['full_post_code'] = $match[1];
            $fields['partial_post_code'] = preg_replace('/\s?\d[A-Z]{2}$/', '', $match[1]);
        }

        // Extract simple address (street number and name only)
        if (preg_match('/(\d+\s+[A-Za-z\s]+(?:Road|Street|Avenue|Lane|Drive|Close|Way|Place))/i', $text, $match)) {
            $address = trim($match[1]);
            if (strlen($address) < 200) { // Ensure it's not too long
                $fields['address_line_1'] = $address;
            }
        }

        // Extract area/city
        if (preg_match('/(Birmingham|London|Manchester|Liverpool|Leeds|Sheffield|Bristol|Cardiff|Edinburgh|Glasgow|Belfast|Erdington|Dudley)/i', $text, $match)) {
            if (!$fields['city']) {
                $fields['city'] = $match[1];
            } else {
                $fields['area'] = $match[1];
            }
        }

        return $fields;
    }

    private function extractPersonalDetails($fields, $text, $textLower)
    {
        // Gender
        if (preg_match('/\b(male|female)\b/i', $textLower, $match)) {
            $fields['gender'] = ucfirst($match[1]);
        }

        // LinkedIn
        if (preg_match('/linkedin\.com\/(?:in\/)?([a-zA-Z0-9\-_]+)/', $text, $match)) {
            $fields['linkedin'] = 'linkedin.com/in/' . $match[1];
        }

        // GitHub
        if (preg_match('/github\.com\/([a-zA-Z0-9_-]+)/', $text, $match)) {
            $fields['github'] = 'github.com/' . $match[1];
        }

        // Nationality
        if (preg_match('/\b(british|pakistani|american|canadian|australian)\b(?:\s+citizen)?/i', $textLower, $match)) {
            $fields['nationality'] = ucfirst($match[1]);
        }

        // Right to work
        if (preg_match('/right to work|eligible to work|british citizen/i', $textLower)) {
            $fields['right_to_work'] = true;
        }

        // Driving license
        if (preg_match('/driving licen|full.*driver|clean.*driver/i', $textLower)) {
            $fields['driving_license'] = true;
        }

        return $fields;
    }

    private function extractSections($fields, $text, $textLower, $lines)
    {
        // Extract Summary
        $fields['summary'] = $this->extractSummary($text);
        
        // Extract Skills
        $fields['skills'] = $this->extractSkills($text, $lines);
        
        // Extract Experience
        $fields['experience'] = $this->extractExperience($text);
        
        // Extract Education
        $fields['education'] = $this->extractEducation($text);

        return $fields;
    }

    private function extractSummary($text)
    {
        $summaryHeaders = ['summary', 'profile', 'personal statement', 'objective', 'about', 'overview'];
        
        foreach ($summaryHeaders as $header) {
            $pattern = "/(?:^|\n)(?:$header)[:\s]*\n?(.*?)(?=\n(?:skills|experience|education|employment|work|career|contact|\+\d|[a-z]+@)|$)/si";
            
            if (preg_match($pattern, $text, $match)) {
                $summary = trim($match[1]);
                
                // Clean the summary
                $summary = preg_replace('/[\+\d\s\-\(\)]{10,}/', '', $summary);
                $summary = preg_replace('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', '', $summary);
                $summary = preg_replace('/\s+/', ' ', $summary);
                $summary = trim($summary);
                
                if (strlen($summary) > 50 && strlen($summary) < 1500) {
                    return $summary;
                }
            }
        }
        
        return null;
    }

    private function extractSkills($text, $lines)
    {
        $skills = [];
        
        // Method 1: Extract from dedicated skills section
        $skillHeaders = ['key skills', 'skills', 'technical skills', 'core competencies'];
        
        foreach ($skillHeaders as $header) {
            $pattern = "/(?:^|\n)(?:$header)[:\s]*\n?(.*?)(?=\n(?:experience|employment|education|work|career)|$)/si";
            
            if (preg_match($pattern, $text, $match)) {
                $skillsText = trim($match[1]);
                $extractedSkills = $this->parseSkillsSection($skillsText);
                
                if (!empty($extractedSkills)) {
                    $skills = array_merge($skills, $extractedSkills);
                    break;
                }
            }
        }

        // Method 2: Look for common technical skills
        $technicalSkills = [
            'PHP', 'JavaScript', 'Python', 'Java', 'HTML', 'CSS', 'Laravel', 'React', 'Vue.js', 
            'Angular', 'Node.js', 'MySQL', 'PostgreSQL', 'MongoDB', 'Git', 'Docker', 'AWS'
        ];
        
        foreach ($technicalSkills as $skill) {
            if (preg_match('/\b' . preg_quote($skill, '/') . '\b/i', $text)) {
                $skills[] = $skill;
            }
        }

        // Method 3: Look for soft skills
        $softSkills = [
            'Communication', 'Leadership', 'Teamwork', 'Problem Solving', 'Time Management',
            'Organization', 'Adaptability', 'Punctuality', 'Customer Service', 'Research'
        ];
        
        foreach ($softSkills as $skill) {
            if (preg_match('/\b' . preg_quote($skill, '/') . '\b/i', $text)) {
                $skills[] = $skill;
            }
        }

        // Clean and deduplicate
        $skills = array_unique(array_filter($skills, function($skill) {
            return strlen(trim($skill)) > 1 && strlen(trim($skill)) < 50;
        }));

        return array_values(array_slice($skills, 0, 15)); // Limit to 15 skills
    }

    private function parseSkillsSection($skillsText)
    {
        $skills = [];
        
        // Try different parsing methods
        if (strpos($skillsText, '•') !== false) {
            // Bullet points
            preg_match_all('/•\s*([^•\n]+)/', $skillsText, $matches);
            $skills = array_map('trim', $matches[1]);
        } elseif (strpos($skillsText, ',') !== false) {
            // Comma separated
            $skills = array_map('trim', explode(',', $skillsText));
        } else {
            // Line separated
            $skills = array_filter(array_map('trim', explode("\n", $skillsText)));
        }

        // Filter valid skills
        $skills = array_filter($skills, function($skill) {
            return strlen($skill) > 1 && strlen($skill) < 50 && 
                   !preg_match('/^\d+$/', $skill) &&
                   !preg_match('/^(experience|education|work|employment)/i', $skill);
        });

        return $skills;
    }

    private function extractExperience($text)
    {
        $experience = [];
        $expHeaders = ['experience', 'employment', 'work experience', 'career history'];
        
        foreach ($expHeaders as $header) {
            $pattern = "/(?:^|\n)(?:$header)[:\s]*\n?(.*?)(?=\n(?:education|skills|qualifications)|$)/si";
            
            if (preg_match($pattern, $text, $match)) {
                $expText = trim($match[1]);
                
                // Split by job entries
                $jobs = preg_split('/\n(?=\d{4}|\d{1,2}\/\d{4}|[A-Z][a-zA-Z\s&,]{10,})/i', $expText);
                
                foreach ($jobs as $job) {
                    $job = trim($job);
                    if (strlen($job) > 50 && strlen($job) < 2000) {
                        $experience[] = $job;
                    }
                }
                
                if (!empty($experience)) {
                    break;
                }
            }
        }
        
        return array_slice($experience, 0, 5); 
    }

    private function extractEducation($text)
    {
        $education = [];
        $eduHeaders = ['education', 'qualifications', 'academic background'];
        
        foreach ($eduHeaders as $header) {
            $pattern = "/(?:^|\n)(?:$header)[:\s]*\n?(.*?)(?=\n(?:experience|skills|employment)|$)/si";
            
            if (preg_match($pattern, $text, $match)) {
                $eduText = trim($match[1]);
                
                // Split by education entries
                $entries = preg_split('/\n(?=\d{4}|[A-Z][a-z]+.*(?:university|college|school))/i', $eduText);
                
                foreach ($entries as $entry) {
                    $entry = trim($entry);
                    if (strlen($entry) > 20 && strlen($entry) < 1000 &&
                        (preg_match('/\d{4}/', $entry) || 
                         preg_match('/(degree|diploma|certificate|university|college|school|gcse)/i', $entry))) {
                        $education[] = $entry;
                    }
                }
                
                if (!empty($education)) {
                    break;
                }
            }
        }
        
        return array_slice($education, 0, 5); 
    }

    private function extractProfessionalInfo($fields, $text, $textLower)
    {
        // Total experience
        if (preg_match('/(\d+\.?\d*)\s*(?:years?|yrs?)\s*(?:of\s*)?(?:experience|exp)/i', $text, $match)) {
            $fields['total_experience'] = $match[1] . ' years';
        }

        // Position title
        $titlePatterns = [
            '/^([A-Za-z\s&]+(?:developer|engineer|manager|analyst|designer|consultant|specialist|nurse|nanny|practitioner))/im',
            '/(?:position|role|title)[:\s]+([A-Za-z\s&]+)/i'
        ];

        foreach ($titlePatterns as $pattern) {
            if (preg_match($pattern, $text, $match)) {
                $title = trim($match[1]);
                if (strlen($title) > 5 && strlen($title) < 100) {
                    $fields['position_title'] = $title;
                    break;
                }
            }
        }

        return $fields;
    }

    private function validateAndTruncateFields($fields)
    {
        foreach ($this->fieldLimits as $field => $limit) {
            if (isset($fields[$field]) && is_string($fields[$field])) {
                if (strlen($fields[$field]) > $limit) {
                    $fields[$field] = substr($fields[$field], 0, $limit - 3) . '...';
                }
            }
        }

        // Clean fields that might have wrong content
        if ($fields['languages_spoken'] && strlen($fields['languages_spoken']) > 200) {
            // If languages_spoken is too long, it's probably wrong content
            $fields['languages_spoken'] = null;
        }

        if ($fields['address_line_1'] && strlen($fields['address_line_1']) > 100) {
            // If address is too long, it's probably experience text
            if (preg_match('/experience|employment|work|responsibilities/i', $fields['address_line_1'])) {
                $fields['address_line_1'] = null;
            }
        }

        return $fields;
    }
}
