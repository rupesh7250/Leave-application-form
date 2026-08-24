<?php

$submitted = false;
$error = "";

$csvFile = "leave_applications.csv";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_name = trim($_POST['student_name']);
    $roll_number  = trim($_POST['roll_number']);
    $department   = trim($_POST['department']);
    $leave_type   = trim($_POST['leave_type']);
    $from_date    = trim($_POST['from_date']);
    $to_date      = trim($_POST['to_date']);
    $reason       = trim($_POST['reason']);

    $fileExists = file_exists($csvFile);

    $file = fopen($csvFile, "a");

    if ($file) {

        if (!$fileExists || filesize($csvFile) == 0) {

            fputcsv($file, [
                "Student Name",
                "Roll Number",
                "Department",
                "Leave Type",
                "From Date",
                "To Date",
                "Reason",
                "Submitted At"
            ]);
        }
        
        fputcsv($file, [
            $student_name,
            $roll_number,
            $department,
            $leave_type,
            $from_date,
            $to_date,
            $reason,
            date("d-m-Y h:i A")
        ]);

        fclose($file);

        $submitted = true;

    } else {

        $error = "Unable to save application. Please check folder permissions.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Leave Application</title>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {

    min-height: 100vh;

    font-family:
        "Segoe UI",
        Arial,
        sans-serif;

    background:
        linear-gradient(
            135deg,
            #4f46e5,
            #7c3aed,
            #c026d3
        );

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 30px 15px;
}

.container {

    width: 100%;

    max-width: 850px;

    background: white;

    border-radius: 25px;

    overflow: hidden;

    box-shadow:
        0 25px 60px
        rgba(0,0,0,0.25);
}

.header {

    background:
        linear-gradient(
            135deg,
            #4338ca,
            #7c3aed
        );

    color: white;

    text-align: center;

    padding: 38px 20px;
}

.header-icon {

    width: 70px;

    height: 70px;

    margin:
        0 auto 15px;

    border-radius: 50%;

    background:
        rgba(255,255,255,0.18);

    display: flex;

    justify-content: center;

    align-items: center;

    font-size: 34px;
}

.header h1 {

    font-size: 30px;

    margin-bottom: 8px;
}

.header p {

    font-size: 15px;

    opacity: 0.9;
}

.form-area {

    padding: 35px;
}

.form-grid {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 20px;
}

.form-group {

    display: flex;

    flex-direction: column;
}

.full {

    grid-column:
        1 / -1;
}

label {

    font-size: 14px;

    font-weight: 600;

    color: #374151;

    margin-bottom: 8px;
}

input,
select,
textarea {

    width: 100%;

    padding:
        13px 15px;

    border:
        2px solid #e5e7eb;

    border-radius: 12px;

    background: #f9fafb;

    font-size: 14px;

    outline: none;

    transition: 0.3s;
}

input:focus,
select:focus,
textarea:focus {

    border-color: #6366f1;

    background: white;

    box-shadow:
        0 0 0 4px
        rgba(99,102,241,0.12);
}

textarea {

    min-height: 110px;

    resize: vertical;
}

.submit-btn {

    width: 100%;

    margin-top: 25px;

    padding: 15px;

    border: none;

    border-radius: 12px;

    color: white;

    font-size: 16px;

    font-weight: 700;

    cursor: pointer;

    background:
        linear-gradient(
            135deg,
            #4f46e5,
            #9333ea
        );

    box-shadow:
        0 8px 20px
        rgba(99,102,241,0.3);

    transition: 0.3s;
}

.submit-btn:hover {

    transform:
        translateY(-2px);

    box-shadow:
        0 12px 25px
        rgba(99,102,241,0.4);
}

.error {

    margin:
        0 35px 25px;

    padding: 15px;

    border-radius: 12px;

    background: #fee2e2;

    color: #b91c1c;

    text-align: center;

    font-weight: 600;
}

.success-page {

    padding: 45px 35px;

    text-align: center;

    animation:
        fadeIn 0.5s ease;
}

.success-icon {

    width: 90px;

    height: 90px;

    margin:
        0 auto 20px;

    background: #22c55e;

    color: white;

    border-radius: 50%;

    display: flex;

    justify-content: center;

    align-items: center;

    font-size: 48px;

    font-weight: bold;

    box-shadow:
        0 10px 30px
        rgba(34,197,94,0.3);
}

.success-page h2 {

    color: #15803d;

    font-size: 28px;

    margin-bottom: 8px;
}

.success-page > p {

    color: #64748b;

    margin-bottom: 30px;
}

.details-card {

    text-align: left;

    background: #f8fafc;

    border:
        1px solid #e2e8f0;

    border-radius: 18px;

    padding: 25px;

    margin-bottom: 25px;
}

.details-card h3 {

    color: #4338ca;

    margin-bottom: 18px;

    font-size: 20px;
}

.detail-row {

    display: flex;

    justify-content:
        space-between;

    gap: 20px;

    padding: 12px 0;

    border-bottom:
        1px solid #e5e7eb;
}

.detail-row:last-child {

    border-bottom: none;
}

.detail-label {

    color: #64748b;

    font-weight: 600;
}

.detail-value {

    color: #1e293b;

    font-weight: 600;

    text-align: right;

    max-width: 60%;
}

.back-btn {

    display: block;

    width: 100%;

    padding: 14px;

    border-radius: 12px;

    background:
        linear-gradient(
            135deg,
            #4f46e5,
            #7c3aed
        );

    color: white;

    text-decoration: none;

    font-size: 15px;

    font-weight: 700;

    transition: 0.3s;
}

.back-btn:hover {

    transform:
        translateY(-2px);

    box-shadow:
        0 8px 20px
        rgba(79,70,229,0.3);
}

@keyframes fadeIn {

    from {

        opacity: 0;

        transform:
            translateY(15px);
    }

    to {

        opacity: 1;

        transform:
            translateY(0);
    }
}

@media(max-width:650px) {

    .form-grid {

        grid-template-columns:
            1fr;
    }

    .full {

        grid-column: auto;
    }

    .form-area {

        padding: 25px 20px;
    }

    .success-page {

        padding:
            35px 20px;
    }

    .detail-row {

        flex-direction:
            column;

        gap: 5px;
    }

    .detail-value {

        text-align: left;

        max-width: 100%;
    }

    .header h1 {

        font-size: 24px;
    }
}

</style>

</head>


<body>


<div class="container">


<?php if (!$submitted): ?>

<div class="header">

    <div class="header-icon">
        📋
    </div>

    <h1>
        Leave Application
    </h1>

    <p>
        Submit your leave request quickly and easily
    </p>

</div>


<div class="form-area">
<form method="POST">
<div class="form-grid">
<div class="form-group">

<label>
👤 Student Name
</label>

<input
    type="text"
    name="student_name"
    placeholder="Enter your full name"
    required>
</div>

<div class="form-group">

<label>
🎓 Roll Number
</label>

<input
    type="text"
    name="roll_number"
    placeholder="Enter roll number"
    required>

</div>

<div class="form-group">

<label>
🏫 Department
</label>

<select
    name="department"
    required>

<option value="">
    Select Department
</option>

<option value="BCA">
    BCA
</option>

<option value="B.Tech">
    B.Tech
</option>

<option value="MCA">
    MCA
</option>

<option value="MBA">
    MBA
</option>

</select>

</div>

<div class="form-group">

<label>
📝 Leave Type
</label>

<select
    name="leave_type"
    required>

<option value="">
    Select Leave Type
</option>

<option value="Sick Leave">
    Sick Leave
</option>

<option value="Casual Leave">
    Casual Leave
</option>

<option value="Emergency Leave">
    Emergency Leave
</option>

<option value="Personal Leave">
    Personal Leave
</option>

</select>

</div>

<div class="form-group">

<label>
📅 From Date
</label>

<input
    type="date"
    name="from_date"
    required>

</div>


<div class="form-group">

<label>
📅 To Date
</label>

<input
    type="date"
    name="to_date"
    required>

</div>

<div class="form-group full">

<label>
💬 Reason for Leave
</label>

<textarea
    name="reason"
    placeholder="Please explain the reason for your leave..."
    required></textarea>

</div>


</div>


<button
    type="submit"
    class="submit-btn">

🚀 Submit Leave Application

</button>


</form>

</div>


<?php

if ($error != "") {

    echo "
    <div class='error'>
        ❌ $error
    </div>
    ";
}

?>

<?php else: ?>

<div class="success-page">


<div class="success-icon">

✓

</div>

<h2>

Application Submitted Successfully!

</h2>

<p>

Your leave application has been received successfully.

</p>

<div class="details-card">


<h3>

📄 Submitted Application

</h3>


<div class="detail-row">

<span class="detail-label">
Student Name
</span>

<span class="detail-value">

<?php echo htmlspecialchars($student_name); ?>

</span>

</div>

<div class="detail-row">

<span class="detail-label">
Roll Number
</span>

<span class="detail-value">
<?php echo htmlspecialchars($roll_number); ?>

</span>
</div>


<div class="detail-row">

<span class="detail-label">
Department
</span>

<span class="detail-value">

<?php echo htmlspecialchars($department); ?>
</span>
</div>

<div class="detail-row">
<span class="detail-label">
Leave Type
</span>
<span class="detail-value">
<?php echo htmlspecialchars($leave_type); ?>
</span>
</div>

<div class="detail-row">

<span class="detail-label">
From Date
</span>

<span class="detail-value">

<?php echo htmlspecialchars($from_date); ?>

</span>

</div>


<div class="detail-row">

<span class="detail-label">
To Date
</span>

<span class="detail-value">

<?php echo htmlspecialchars($to_date); ?>

</span>

</div>
<div class="detail-row">

<span class="detail-label">
Reason
</span>

<span class="detail-value">
<?php echo htmlspecialchars($reason); ?>

</span>
</div>
</div>

<a
href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
class="back-btn">

← Back to New Application

</a>
</div>
<?php endif; ?>
</div>
</body>
</html>