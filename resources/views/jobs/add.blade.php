@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="blogapp-content">
                    <div class="blogapp-content">
                        <div class="blogapp-detail-wrap">
                            <header class="blog-header">
                                <div class="d-flex align-items-center">
                                    <a class="blogapp-title link-dark" href="#">
                                        <h1>Add Job</h1>
                                    </a>
                                </div>
                            </header>
                            <div class="blog-body">
                                <div data-simplebar class="nicescroll-bar">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xxl-12 col-lg-12">
                                                <form class="edit-post-form jobform" action="{{ url('/jobs') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <!-- Job Basic Information -->
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Job Title*</label>
                                                            <input class="form-control" placeholder="Job Title"
                                                                name="job_title" required>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Number of openings*</label>
                                                            <input type="number" class="form-control" name="no_of_openings"
                                                                placeholder="Number of openings" required min="1">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label"> Company</label>
                                                            <select class="form-select" name="company_id">
                                                                <option selected value="">Select Company</option>
                                                                @foreach ($companies as $company)
                                                                    <option value="{{ $company->id }}">{{ $company->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Target Company</label>
                                                            <select class="form-select" name="target_company_id">
                                                                <option selected value="">Select Company</option>
                                                                @foreach ($target_companies as $company)
                                                                    <option value="{{ $company->id }}">{{ $company->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Job Description -->
                                                    <div class="form-group">
                                                        <label class="form-label">Job Description*</label>
                                                        <div class="card card-border rounded-top-start-0">
                                                            <div class="card-body">
                                                                <div class="tab-content mt-0">
                                                                    <div class="tab-pane fade show active" id="tab_classic">
                                                                        <div class="tinymce-wrap">
                                                                            <textarea id="classic" name="job_description"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Experience & Salary -->
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Location Type*</label>
                                                            <select class="form-select" name="location_type" required>
                                                                <option selected value="Onsite">Onsite</option>
                                                                <option value="Remote">Remote</option>
                                                                <option value="Hybrid">Hybrid</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Job Type*</label>
                                                            <input type="text" class="form-control" name="job_type"
                                                                placeholder="Job Type" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Minimum Experience*</label>
                                                            <select class="form-select" name="min_experience" required>
                                                                <option selected value="0">Fresher</option>
                                                                <option value="1">1 Year</option>
                                                                <option value="2">2 Years</option>
                                                                <option value="3">3 Years</option>
                                                                <option value="4">4 Years</option>
                                                                <option value="5">5 Years</option>
                                                                <option value="6">6 Years</option>
                                                                <option value="7">7 Years</option>
                                                                <option value="8">8 Years</option>
                                                                <option value="9">9 Years</option>
                                                                <option value="10">10 Years</option>
                                                                <option value="11">11 Years</option>
                                                                <option value="12">12 Years</option>
                                                                <option value="13">13 Years</option>
                                                                <option value="14">14 Years</option>
                                                                <option value="15">15 Years</option>
                                                                <option value="16">16 Years</option>
                                                                <option value="17">17 Years</option>
                                                                <option value="18">18 Years</option>
                                                                <option value="19">19 Years</option>
                                                                <option value="20">20 Years</option>
                                                                <option value="21">20+ Years</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Maximum Experience*</label>
                                                            <select class="form-select" name="max_experience" required>
                                                                <option selected value="0">Fresher</option>
                                                                <option value="1">1 Year</option>
                                                                <option value="2">2 Years</option>
                                                                <option value="3">3 Years</option>
                                                                <option value="4">4 Years</option>
                                                                <option value="5">5 Years</option>
                                                                <option value="6">6 Years</option>
                                                                <option value="7">7 Years</option>
                                                                <option value="8">8 Years</option>
                                                                <option value="9">9 Years</option>
                                                                <option value="10">10 Years</option>
                                                                <option value="11">11 Years</option>
                                                                <option value="12">12 Years</option>
                                                                <option value="13">13 Years</option>
                                                                <option value="14">14 Years</option>
                                                                <option value="15">15 Years</option>
                                                                <option value="16">16 Years</option>
                                                                <option value="17">17 Years</option>
                                                                <option value="18">18 Years</option>
                                                                <option value="19">19 Years</option>
                                                                <option value="20">20 Years</option>
                                                                <option value="21">20+ Years</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Salary Type*</label>
                                                            <select class="form-select" name="salary_type" required>
                                                                <option selected value="Annual">Annual</option>
                                                                <option value="Monthly">Monthly</option>
                                                                <option value="Weekly">Weekly</option>
                                                                <option value="Daily">Daily</option>
                                                                <option value="Hourly">Hourly</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Currency*</label>
                                                            <select name="currency" class="form-select" required>
                                                                <option value="">Select Currency</option>
                                                                <option selected disabled>Select Currency</option>
                                                                <option value="$">$ - United States Dollar</option>
                                                                <option value="€">€ - Euro</option>
                                                                <option value="£">£ - British Pound</option>
                                                                <option value="¥">¥ - Japanese Yen</option>
                                                                <option value="C$">C$ - Canadian Dollar</option>
                                                                <option value="A$">A$ - Australian Dollar</option>
                                                                <option value="CHF">CHF - Swiss Franc</option>
                                                                <option value="¥">¥ - Chinese Yuan</option>
                                                                <option value="₹">₹ - Indian Rupee</option>
                                                                <option value="R$">R$ - Brazilian Real</option>
                                                                <option value="R">R - South African Rand</option>
                                                                <option value="kr">kr - Swedish Krona</option>
                                                                <option value="kr">kr - Norwegian Krone</option>
                                                                <option value="$">$ - Mexican Peso</option>
                                                                <option value="₽">₽ - Russian Ruble</option>
                                                                <option value="$">$ - Singapore Dollar</option>
                                                                <option value="$">$ - Hong Kong Dollar</option>
                                                                <option value="₩">₩ - South Korean Won</option>
                                                                <option value="$">$ - New Zealand Dollar</option>
                                                                <option value="₺">₺ - Turkish Lira</option>
                                                                <option value="د.إ">د.إ - UAE Dirham</option>
                                                                <option value="ر.س">ر.س - Saudi Riyal</option>
                                                                <option value="£">£ - Egyptian Pound</option>
                                                                <option value="฿">฿ - Thai Baht</option>
                                                                <option value="Rp">Rp - Indonesian Rupiah</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Minimum Salary</label>
                                                            <input type="number" class="form-control" name="min_salary"
                                                                min="0" placeholder="Minimum Salary">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Maximum Salary</label>
                                                            <input type="number" class="form-control" name="max_salary"
                                                                min="0" placeholder="Maximum Salary">
                                                        </div>
                                                    </div>

                                                    <!-- Education -->
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Educational Qualification</label>
                                                            <select class="form-select" name="educational_qualification">
                                                                <option selected value="Not available">Not available
                                                                </option>
                                                                <option value="High School Dropout">High School Dropout
                                                                </option>
                                                                <option value="High School Diploma">High School Diploma
                                                                </option>
                                                                <option value="Associate Degree">Associate Degree</option>
                                                                <option value="Bachelor Degree">Bachelor Degree</option>
                                                                <option value="Master Degree">Master Degree</option>
                                                                <option value="Docarte Degree">Docarte Degree</option>
                                                                <option value="BBA">BBA</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Educational Specialization</label>
                                                            <input type="text" class="form-control"
                                                                name="educational_specialization"
                                                                placeholder="Educational Specialization">
                                                        </div>
                                                    </div>

                                                    <!-- Skills Input -->
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-12">
                                                            <label class="form-label">Skills</label>
                                                            <input type="text" class="form-control" name="skills"
                                                                id="skillsInput" placeholder="Type skill and press Enter">
                                                        </div>
                                                    </div>

                                                    <!-- Container to display added skills -->
                                                    <div id="skillsContainer" class="d-flex flex-wrap gap-2 my-2"></div>

                                                    <!-- Location -->
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Locality</label>
                                                            <input type="text" class="form-control" name="locality"
                                                                placeholder="Locality">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">City*</label>
                                                            <input type="text" class="form-control" name="city"
                                                                placeholder="City" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">State*</label>
                                                            <input type="text" class="form-control" name="state"
                                                                placeholder="State" required>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Country*</label>
                                                            <input type="text" class="form-control" name="country"
                                                                placeholder="Country" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Postal Code</label>
                                                            <input type="text" class="form-control" name="postal_code"
                                                                placeholder="Postal Code">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Full Address</label>
                                                            <textarea class="form-control" name="full_address" rows="2" placeholder="Full Address"></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- Team & Questions -->
                                                    <div class="form-group row">


                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Collaborator</label>

                                                            <select id="input_tags"
                                                                class="form-control select2 select2-multiple"
                                                                multiple="multiple" data-placeholder="Choose"
                                                                multiple="multiple" name="collaborator[]">
                                                                <!-- Options would be populated dynamically -->
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}">{{ $user->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>


                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label">Attchment</label>
                                                            <input type="file" class="form-control" name="attchment"
                                                                placeholder="Attchment">

                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-12">
                                                            <label class="form-label">Note For Candidates</label>
                                                            <textarea class="form-control" name="candidate_note" rows="3" placeholder="Note for candidates"></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- Application Questions -->
                                                    <div class="form-group row">
                                                        <div class="form-group col-lg-12">
                                                            <label class="form-label">Job Application Form
                                                                Questions</label>
                                                            <a href="javascript:void(0);" id="addQuestionBtn"
                                                                class="btn btn-sm btn-primary ms-3">
                                                                <span>
                                                                    <span class="icon">
                                                                        <span class="feather-icon">
                                                                            <i data-feather="plus"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span class="btn-text">Add Question</span>
                                                                </span>
                                                            </a>
                                                            <div id="questionsContainer"
                                                                style="display: none; margin-top: 10px;">
                                                                <!-- Questions will be added here -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <div class="form-group row mt-4">
                                                        <div class="col-lg-12 text-end">
                                                            <button type="submit" class="btn btn-primary">Save Job
                                                                Posting</button>

                                                        </div>
                                                    </div>
                                                </form>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const addQuestionBtn = document.getElementById('addQuestionBtn');
                const questionsContainer = document.getElementById('questionsContainer');
                let questionCount = 0;

                addQuestionBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Show container if it's hidden
                    if (questionsContainer.style.display === 'none') {
                        questionsContainer.style.display = 'block';
                    }

                    // Create new question input
                    questionCount++;
                    const questionDiv = document.createElement('div');
                    questionDiv.className = 'question-group mb-2';
                    questionDiv.innerHTML = `
            <div class="input-group">
                <input type="text" class="form-control" name="questions[]" placeholder="Enter question ${questionCount}" required>
                <button class="btn btn-outline-danger remove-question" type="button">
                    <span class="icon"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span></span>
                </button>
            </div>
        `;

                    questionsContainer.appendChild(questionDiv);

                    // Initialize Feather icons
                    if (window.feather) {
                        feather.replace();
                    }
                });

                // Handle question removal
                questionsContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-question') || e.target.closest(
                            '.remove-question')) {
                        e.preventDefault();
                        const questionGroup = e.target.closest('.question-group');
                        questionGroup.remove();

                        // Renumber remaining questions
                        const remainingQuestions = questionsContainer.querySelectorAll('.question-group');
                        remainingQuestions.forEach((group, index) => {
                            const input = group.querySelector('input');
                            input.placeholder = `Enter question ${index + 1}`;
                        });

                        questionCount = remainingQuestions.length;

                        // Hide container if no questions left
                        if (questionsContainer.children.length === 0) {
                            questionsContainer.style.display = 'none';
                            questionCount = 0;
                        }
                    }
                });
            });
        </script>
        <script>
            $("#input_tags").select2({
                tags: true,
                tokenSeparators: [',', ' ']

            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                tinymce.init({
                    selector: '#classic',
                    setup: function(editor) {
                        editor.on('change', function() {
                            editor.save(); // keeps textarea updated
                        });
                    }
                });

                document.querySelector('jobform').addEventListener('submit', function() {
                    tinymce.triggerSave(); // final push to textarea
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Tagify
                const input = document.getElementById('skillsInput');
                const tagify = new Tagify(input, {
                    whitelist: [], // You can predefine skills here if needed
                    dropdown: {
                        enabled: 0 // Disable dropdown
                    },
                    originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
                });

                // Add skill when Enter is pressed
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && input.value.trim()) {
                        e.preventDefault();

                        // Create a new skill tag
                        const skill = input.value.trim();
                        const skillTag = document.createElement('span');
                        skillTag.className = 'badge badge-soft-primary py-2 px-3';
                        skillTag.innerHTML = `
                ${skill}
                <span class="remove-skill" style="cursor:pointer; margin-left:5px;">×</span>
            `;

                        // Add to skills container
                        document.getElementById('skillsContainer').appendChild(skillTag);

                        // Clear input
                        input.value = '';

                        // Add remove functionality
                        skillTag.querySelector('.remove-skill').addEventListener('click', function() {
                            skillTag.remove();
                        });
                    }
                });
            });
        </script>
    @endsection
