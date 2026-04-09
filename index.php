<?php
session_start();

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

$errors = [];
$formData = [
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'phone' => '',
    'dob' => '',
    'gender' => '',
    'course' => '',
    'address' => '',
];

function sanitize_input(string $value): string
{
    return trim($value);
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($formData as $field => $defaultValue) {
        $formData[$field] = sanitize_input($_POST[$field] ?? '');
    }

    if ($formData['first_name'] === '') {
        $errors['first_name'] = 'First name is required.';
    }

    if ($formData['last_name'] === '') {
        $errors['last_name'] = 'Last name is required.';
    }

    if ($formData['email'] === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if ($formData['phone'] === '') {
        $errors['phone'] = 'Phone number is required.';
    } elseif (!preg_match('/^[0-9]{10}$/', $formData['phone'])) {
        $errors['phone'] = 'Phone number must contain 10 digits.';
    }

    if ($formData['dob'] === '') {
        $errors['dob'] = 'Date of birth is required.';
    }

    if ($formData['gender'] === '') {
        $errors['gender'] = 'Please select a gender.';
    }

    if ($formData['course'] === '') {
        $errors['course'] = 'Course is required.';
    }

    if ($formData['address'] === '') {
        $errors['address'] = 'Address is required.';
    }

    if ($errors === []) {
        $_SESSION['students'][] = [
            'full_name' => $formData['first_name'] . ' ' . $formData['last_name'],
            'email' => $formData['email'],
            'phone' => $formData['phone'],
            'dob' => $formData['dob'],
            'gender' => $formData['gender'],
            'course' => $formData['course'],
            'address' => $formData['address'],
            'registered_on' => date('d M Y, h:i A'),
        ];

        $_SESSION['flash_message'] = 'Student registered successfully.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

$students = $_SESSION['students'];
$flashMessage = $_SESSION['flash_message'] ?? '';
$coursesTracked = count(array_unique(array_column($students, 'course')));
unset($_SESSION['flash_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="page-shell">
        <section class="intro-panel">
            <p class="eyebrow">NA Assignment</p>
            <h1>Student Registration Form</h1>
            <p class="intro-copy">
                Register student details using PHP and immediately display each submission in a clean card layout.
            </p>
            <div class="stats-strip">
                <div class="stat-box">
                    <span class="stat-number"><?php echo count($students); ?></span>
                    <span class="stat-label">Registered Students</span>
                </div>
                <div class="stat-box">
                    <span class="stat-number"><?php echo $coursesTracked; ?></span>
                    <span class="stat-label">Courses Tracked</span>
                </div>
            </div>
        </section>

        <section class="form-panel">
            <div class="panel-header">
                <h2>Enter Student Details</h2>
                <p>All fields are required.</p>
            </div>

            <?php if ($flashMessage !== ''): ?>
                <div class="alert success"><?php echo escape($flashMessage); ?></div>
            <?php endif; ?>

            <form method="post" class="registration-form" novalidate>
                <div class="form-grid">
                    <div class="field-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo escape($formData['first_name']); ?>" placeholder="Enter first name">
                        <?php if (isset($errors['first_name'])): ?>
                            <small class="error-text"><?php echo escape($errors['first_name']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="field-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo escape($formData['last_name']); ?>" placeholder="Enter last name">
                        <?php if (isset($errors['last_name'])): ?>
                            <small class="error-text"><?php echo escape($errors['last_name']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="field-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo escape($formData['email']); ?>" placeholder="student@example.com">
                        <?php if (isset($errors['email'])): ?>
                            <small class="error-text"><?php echo escape($errors['email']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="field-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" maxlength="10" value="<?php echo escape($formData['phone']); ?>" placeholder="10-digit mobile number">
                        <?php if (isset($errors['phone'])): ?>
                            <small class="error-text"><?php echo escape($errors['phone']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="field-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?php echo escape($formData['dob']); ?>">
                        <?php if (isset($errors['dob'])): ?>
                            <small class="error-text"><?php echo escape($errors['dob']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="field-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select gender</option>
                            <option value="Male" <?php echo $formData['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $formData['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo $formData['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                        <?php if (isset($errors['gender'])): ?>
                            <small class="error-text"><?php echo escape($errors['gender']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="field-group field-group-full">
                        <label for="course">Course</label>
                        <input type="text" id="course" name="course" value="<?php echo escape($formData['course']); ?>" placeholder="BCA, BSc, MCA, etc.">
                        <?php if (isset($errors['course'])): ?>
                            <small class="error-text"><?php echo escape($errors['course']); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="field-group field-group-full">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="4" placeholder="Enter address"><?php echo escape($formData['address']); ?></textarea>
                        <?php if (isset($errors['address'])): ?>
                            <small class="error-text"><?php echo escape($errors['address']); ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" class="submit-button">Register Student</button>
            </form>
        </section>
    </main>

    <section class="cards-section">
        <div class="section-heading">
            <h2>Submitted Student Data</h2>
            <p>Each successful registration appears below as a card.</p>
        </div>

        <?php if ($students === []): ?>
            <div class="empty-state">
                <h3>No submissions yet</h3>
                <p>Fill out the form and submit it to see the card layout.</p>
            </div>
        <?php else: ?>
            <div class="card-grid">
                <?php foreach (array_reverse($students) as $student): ?>
                    <article class="student-card">
                        <div class="card-top">
                            <div class="avatar-circle">
                                <?php echo escape(strtoupper(substr($student['full_name'], 0, 1))); ?>
                            </div>
                            <div>
                                <h3><?php echo escape($student['full_name']); ?></h3>
                                <p class="course-tag"><?php echo escape($student['course']); ?></p>
                            </div>
                        </div>

                        <div class="card-details">
                            <p><span>Email:</span> <?php echo escape($student['email']); ?></p>
                            <p><span>Phone:</span> <?php echo escape($student['phone']); ?></p>
                            <p><span>DOB:</span> <?php echo escape(date('d M Y', strtotime($student['dob']))); ?></p>
                            <p><span>Gender:</span> <?php echo escape($student['gender']); ?></p>
                            <p><span>Address:</span> <?php echo escape($student['address']); ?></p>
                        </div>

                        <p class="registered-time">Registered on <?php echo escape($student['registered_on']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</body>
</html>
