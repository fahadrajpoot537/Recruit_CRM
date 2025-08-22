@extends('layouts.app')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Parser - Enhanced Interface</title>

    <style>
        .main-container {
            padding: 40px 0;
        }

        .upload-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 25px;
            text-align: center;
            border-bottom: none;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 600;
            color: black;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .upload-area {
            border: 3px dashed #49e4ff;
            border-radius: 15px;
            padding: 100px 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            background: rgba(143, 229, 255, 0.05);
        }

        .upload-area:hover {
            border-color: #05b0ce;
            background: rgba(221, 249, 255, 0.15);
            transform: translateY(-2px);
        }

        .upload-area.dragover {
            border-color: #05b0ce;
            background: rgba(221, 249, 255, 0.15);
            transform: scale(1.02);
        }

        .upload-icon {
            font-size: 48px;
            color: #05b0ce;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .upload-area:hover .upload-icon {
            color: #05b0ce;
            transform: scale(1.1);
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .btn-parse {
            background: linear-gradient(135deg, #667eea 0%, #00b6ee 100%);
            border: none;
            padding: 15px 40px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-parse:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(2, 176, 230, 0.4);
            color: white;
        }

        .btn-parse:disabled {
            background: #6c757d;
            transform: none;
            box-shadow: none;
        }

        .progress-container {
            margin: 20px 0;
            display: none;
        }

        .progress {
            height: 8px;
            border-radius: 4px;
            background: rgba(102, 126, 234, 0.1);
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(135deg, #667eea 0%, #12cefd 100%);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .file-preview {
            margin-top: 20px;
            padding: 20px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 15px;
            display: none;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            background: white;
            border-radius: 8px;
            margin-bottom: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .file-info {
            display: flex;
            align-items: center;
        }

        .file-icon {
            color: #667eea;
            margin-right: 12px;
            font-size: 20px;
        }

        .file-name {
            font-weight: 500;
            color: #333;
        }

        .file-size {
            color: #666;
            font-size: 0.85em;
        }

        .remove-file {
            color: #dc3545;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-file:hover {
            color: #c82333;
            transform: scale(1.2);
        }

        .results-section {
            margin-top: 40px;
            display: none;
        }

        .result-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #667eea;
        }

        .candidate-name {
            color: #333;
            font-weight: 600;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .candidate-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            padding: 8px;
        }

        .detail-icon {
            color: #667eea;
            margin-right: 10px;
            width: 20px;
        }

        .skills-container {
            margin-top: 15px;
        }

        .skill-tag {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #00abdf 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            margin: 3px;
            font-size: 0.85em;
            font-weight: 500;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .spinner {
            border: 4px solid rgba(102, 126, 234, 0.1);
            border-left: 4px solid #00c4f5;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .alert-custom {
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success-custom {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }

        .alert-danger-custom {
            background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
            color: white;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 20px 0;
            }

            .upload-area {
                padding: 30px 15px;
            }

            .candidate-details {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container main-container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card upload-card">
                    <div class="card-header">
                        <h4><i class="fas fa-brain me-2"></i>CV Parser</h4>
                        {{-- <p class="mb-0 mt-2" style="opacity: 0.9;">Upload your CVs and let our AI extract key
                            information</p> --}}
                    </div>

                    <div class="card-body p-4">
                        <!-- Alerts -->
                        <div id="alertContainer"></div>

                        <!-- Upload Section -->
                        <div class="upload-section">
                            <form action="{{ route('resume.uploadMultiple') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="upload-area" id="uploadArea">
                                    <input type="file" class="file-input" name="resumes[]"
                                        accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" required multiple>
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <p>Drag & drop single or multiple CV(s) or click to upload</p>

                                </div>
                                <button type="submit" class="btn-parse mt-3">Parse CV</button>
                            </form>

                            <!-- Progress -->
                            <div class="progress-container" id="progressContainer">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Processing...</span>
                                    <span class="text-muted" id="progressText">0%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" id="progressBar" style="width: 0%"></div>
                                </div>
                            </div>

                            <!-- Loading Spinner -->
                            <div class="loading-spinner" id="loadingSpinner">
                                <div class="spinner"></div>
                                <p class="text-muted">AI is analyzing your CVs...</p>
                            </div>

                        </div>

                        <!-- Results Section -->
                        <div class="results-section" id="resultsSection">
                            <hr class="my-5">
                            <h5 class="mb-4"><i class="fas fa-chart-bar me-2"></i>Parsing Results</h5>
                            <div id="resultsContainer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        class CVParser {
            constructor() {
                this.files = [];
                this.apiEndpoint = 'https://n8n.srv904634.hstgr.cloud/form/e781e55c-d1d3-4f01-89d8-2593824b6df6';
                this.initializeElements();
                this.bindEvents();
            }

            initializeElements() {
                this.uploadArea = document.getElementById('uploadArea');
                this.fileInput = document.getElementById('fileInput');
                this.filePreview = document.getElementById('filePreview');
                this.fileList = document.getElementById('fileList');
                this.parseBtn = document.getElementById('parseBtn');
                this.progressContainer = document.getElementById('progressContainer');
                this.progressBar = document.getElementById('progressBar');
                this.progressText = document.getElementById('progressText');
                this.loadingSpinner = document.getElementById('loadingSpinner');
                this.resultsSection = document.getElementById('resultsSection');
                this.resultsContainer = document.getElementById('resultsContainer');
                this.alertContainer = document.getElementById('alertContainer');
            }

            bindEvents() {

                this.fileInput.addEventListener('change', (e) => this.handleFileSelect(e));

                this.uploadArea.addEventListener('dragover', (e) => this.handleDragOver(e));
                this.uploadArea.addEventListener('dragleave', (e) => this.handleDragLeave(e));
                this.uploadArea.addEventListener('drop', (e) => this.handleDrop(e));

                this.parseBtn.addEventListener('click', () => this.parseFiles());
            }

            handleFileSelect(e) {
                const files = Array.from(e.target.files);
                this.addFiles(files);
            }

            handleDragOver(e) {
                e.preventDefault();
                this.uploadArea.classList.add('dragover');
            }

            handleDragLeave(e) {
                e.preventDefault();
                this.uploadArea.classList.remove('dragover');
            }

            handleDrop(e) {
                e.preventDefault();
                this.uploadArea.classList.remove('dragover');
                const files = Array.from(e.dataTransfer.files);
                this.addFiles(files);
            }

            addFiles(newFiles) {
                const validFiles = newFiles.filter(file => this.validateFile(file));
                this.files = [...this.files, ...validFiles];
                this.updateFilePreview();
                this.updateParseButton();
            }

            validateFile(file) {
                const allowedTypes = ['application/pdf', 'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'image/png', 'image/jpeg', 'image/jpg'
                ];
                const maxSize = 2 * 1024 * 1024; // 2MB

                if (!allowedTypes.includes(file.type)) {
                    this.showAlert('Invalid file type. Please upload PDF, DOC, DOCX, PNG, JPG, or JPEG files.',
                        'danger');
                    return false;
                }

                if (file.size > maxSize) {
                    this.showAlert(`File ${file.name} is too large. Maximum size is 2MB.`, 'danger');
                    return false;
                }

                return true;
            }

            updateFilePreview() {
                if (this.files.length === 0) {
                    this.filePreview.style.display = 'none';
                    return;
                }

                this.filePreview.style.display = 'block';
                this.fileList.innerHTML = '';

                this.files.forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    fileItem.innerHTML = `
                        <div class="file-info">
                            <i class="fas ${this.getFileIcon(file.type)} file-icon"></i>
                            <div>
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${this.formatFileSize(file.size)}</div>
                            </div>
                        </div>
                        <i class="fas fa-times remove-file" onclick="cvParser.removeFile(${index})"></i>
                    `;
                    this.fileList.appendChild(fileItem);
                });
            }

            getFileIcon(mimeType) {
                if (mimeType.includes('pdf')) return 'fa-file-pdf';
                if (mimeType.includes('word')) return 'fa-file-word';
                if (mimeType.includes('image')) return 'fa-file-image';
                return 'fa-file';
            }

            formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            removeFile(index) {
                this.files.splice(index, 1);
                this.updateFilePreview();
                this.updateParseButton();
            }

            updateParseButton() {
                this.parseBtn.disabled = this.files.length === 0;
            }

            async parseFiles() {
                if (this.files.length === 0) return;

                this.showLoading(true);
                this.parseBtn.disabled = true;

                const results = [];
                const errors = [];

                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    const progress = ((i + 1) / this.files.length) * 100;

                    this.updateProgress(progress);

                    try {
                        const result = await this.parseFile(file);
                        results.push({
                            file: file.name,
                            data: result
                        });
                    } catch (error) {
                        errors.push({
                            file: file.name,
                            error: error.message
                        });
                    }
                }

                this.showLoading(false);
                this.displayResults(results, errors);
                this.parseBtn.disabled = false;
            }

            async parseFile(file) {
                const formData = new FormData();
                formData.append('file', file);

                const response = await fetch(this.apiEndpoint, {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const result = await response.json();
                return result;
            }

            updateProgress(percentage) {
                this.progressBar.style.width = `${percentage}%`;
                this.progressText.textContent = `${Math.round(percentage)}%`;
            }

            showLoading(show) {
                if (show) {
                    this.progressContainer.style.display = 'block';
                    this.loadingSpinner.style.display = 'block';
                    this.updateProgress(0);
                } else {
                    this.progressContainer.style.display = 'none';
                    this.loadingSpinner.style.display = 'none';
                }
            }

            displayResults(results, errors) {
                this.resultsContainer.innerHTML = '';

                if (errors.length > 0) {
                    errors.forEach(error => {
                        this.showAlert(`Failed to parse ${error.file}: ${error.error}`, 'danger');
                    });
                }

                if (results.length === 0) {
                    this.showAlert('No CVs were successfully parsed.', 'danger');
                    return;
                }

                this.showAlert(`Successfully parsed ${results.length} CV(s)!`, 'success');
                this.resultsSection.style.display = 'block';

                results.forEach(result => {
                    const resultCard = this.createResultCard(result.data, result.file);
                    this.resultsContainer.appendChild(resultCard);
                });

                // Scroll to results
                this.resultsSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            createResultCard(data, filename) {
                const card = document.createElement('div');
                card.className = 'result-card';

                const name = data.name?.raw || data.candidate_name || 'Unknown Candidate';
                const email = data.emails?.[0] || data.email || 'N/A';
                const phone = data.phoneNumbers?.[0] || data.phone_number || 'N/A';
                const skills = data.skills || [];
                const experience = data.workExperience || [];
                const location = data.location?.formatted || 'N/A';

                card.innerHTML = `
                    <div class="candidate-name">
                        <i class="fas fa-user me-2"></i>${name}
                        <small class="text-muted ms-2">(${filename})</small>
                    </div>
                    
                    <div class="candidate-details">
                        <div class="detail-item">
                            <i class="fas fa-envelope detail-icon"></i>
                            <span>${email}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-phone detail-icon"></i>
                            <span>${phone}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt detail-icon"></i>
                            <span>${location}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-briefcase detail-icon"></i>
                            <span>${experience.length ? experience[0].jobTitle || 'N/A' : 'N/A'}</span>
                        </div>
                    </div>

                    ${skills.length > 0 ? `
                            <div class="skills-container">
                                <h6><i class="fas fa-cogs me-2"></i>Skills:</h6>
                                ${skills.map(skill => `<span class="skill-tag">${typeof skill === 'string' ? skill : skill.name || skill}</span>`).join('')}
                            </div>
                        ` : ''}
                `;

                return card;
            }

            showAlert(message, type) {
                const alert = document.createElement('div');
                alert.className = `alert alert-${type}-custom alert-custom`;
                alert.innerHTML = `
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                    ${message}
                `;

                this.alertContainer.appendChild(alert);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 5000);
            }
        }

        // Initialize the CV Parser
        const cvParser = new CVParser();
    </script>
@endsection
