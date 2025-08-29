<?php
//Miar hazem shehada
//220222624

$students = [
    [
        'id' => '20003',
        'name' => 'Ahmed Ali',
        'email' => 'ahmed@gmail.com',
        'gpa' => 88.7
    ],
    [
        'id' => '30304',
        'name' => 'Mona Khalid',
        'email' => 'mona@gmail.com',
        'gpa' => 78.5
    ],
    [
        'id' => '10002',
        'name' => 'Bilal Hmaza',
        'email' => 'bilal@gmail.com',
        'gpa' => 98.7
    ],
    [
        'id' => '10005',
        'name' => 'Said Ali',
        'email' => 'said@gmail.com',
        'gpa' => 98.7
    ],
    [
        'id' => '10007',
        'name' => 'Mohammed Ahmed',
        'email' => 'mohamed@gmail.com',
        'gpa' => 98.7
    ]
];

function getRating($gpa)
{
    if ($gpa >= 90)
        return 'ممتاز';
    if ($gpa >= 80)
        return 'جيد جداً';
    if ($gpa >= 70)
        return 'جيد';
    if ($gpa >= 60)
        return 'مقبول';
    return 'راسب';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $newStudent = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'gpa' => floatval($_POST['gpa'])
    ];

    $students[] = $newStudent;
    $notification = "تم إضافة الطالب بنجاح!";
}

$searchResults = $students;
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $searchResults = array_filter($students, function ($student) use ($searchQuery) {
        return strpos($student['name'], $searchQuery) !== false ||
            strpos($student['id'], $searchQuery) !== false ||
            strpos($student['email'], $searchQuery) !== false;
    });
}

$totalStudents = count($students);
$averageGPA = array_sum(array_column($students, 'gpa')) / $totalStudents;
$maxGPA = max(array_column($students, 'gpa'));
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة الطلاب - الجامعة الإسلامية بغزة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-dark: #0e0e26;
            --primary-light: #313751;
            --secondary: #168ea2;
            --accent: #549c74;
            --accent-2: #1b7e43;
            --accent-3: #1484bc;
            --text-dark: #0e0e26;
            --text-medium: #5c5c68;
            --text-light: #6f6f84;
            --gray-dark: #747474;
            --gray-medium: #8c97a0;
            --gray-light: #acacb4;
            --gray-very-light: #bcbcbc;
            --gray-extra-light: #cfcfd2;
            --bg-light: #f9fbf9;
            --bg-very-light: #ecf0ef;
            --bg-extra-light: #e4e4f3;
            --bg-gray-light: #e4e4dc;
            --bg-blue-light: #dce4e8;
            --bg-white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--bg-very-light), var(--bg-blue-light));
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
            color: white;
            padding: 15px 0;
            box-shadow: 0 4px 20px rgba(14, 14, 38, 0.2);
            border-bottom: 5px solid var(--accent);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 80px;
            height: 80px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            box-shadow: 0 0 15px rgba(14, 14, 38, 0.3);
            padding: 5px;
            border: 2px solid var(--accent);
        }

        .logo img {
            width: 125%;
            height: 125%;
            object-fit: cover;
            border-radius: 60%;
        }

        .university-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }

        .university-name span {
            display: block;
            font-size: 1rem;
            font-weight: normal;
            margin-top: 5px;
            color: var(--bg-very-light);
        }

        .academic-year {
            background: var(--accent-3);
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            box-shadow: 0 0 10px rgba(20, 132, 188, 0.4);
        }

        .main-title {
            text-align: center;
            margin: 25px 0;
            color: var(--primary-dark);
            font-size: 2.2rem;
            position: relative;
            padding-bottom: 15px;
        }

        .main-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        @media (max-width: 992px) {
            .content-wrapper {
                grid-template-columns: 1fr;
            }
        }

        .form-section {
            background: var(--bg-white);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(14, 14, 38, 0.1);
            border-top: 5px solid var(--secondary);
        }

        .section-title {
            color: var(--primary-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--accent);
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--primary-light);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-extra-light);
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s;
            background: var(--bg-very-light);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(22, 142, 162, 0.2);
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: linear-gradient(135deg, var(--secondary), var(--accent-3));
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(22, 142, 162, 0.3);
        }

        .btn:hover {
            background: linear-gradient(135deg, var(--accent-3), var(--secondary));
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(22, 142, 162, 0.4);
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        .students-section {
            background: var(--bg-white);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(14, 14, 38, 0.1);
            border-top: 5px solid var(--accent);
        }

        .search-box {
            display: flex;
            margin-bottom: 25px;
        }

        .search-box input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid var(--gray-extra-light);
            border-radius: 6px 0 0 6px;
            font-size: 16px;
            background: var(--bg-very-light);
        }

        .search-box button {
            padding: 0 20px;
            background: var(--secondary);
            color: white;
            border: none;
            border-radius: 0 6px 6px 0;
            cursor: pointer;
            transition: all 0.3s;
        }

        .search-box button:hover {
            background: var(--accent-3);
        }

        .student-card {
            background: linear-gradient(135deg, var(--bg-extra-light), var(--bg-white));
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            border-right: 5px solid var(--accent);
            transition: all 0.3s;
            box-shadow: 0 3px 10px rgba(84, 156, 116, 0.1);
        }

        .student-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(84, 156, 116, 0.2);
        }

        .student-name {
            font-size: 1.4rem;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }

        .student-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .student-detail {
            display: flex;
            align-items: center;
        }

        .student-detail i {
            margin-left: 10px;
            color: var(--secondary);
        }

        .student-gpa {
            font-weight: bold;
            font-size: 1.2rem;
            color: var(--accent-2);
        }

        .student-rating {
            display: inline-block;
            padding: 5px 12px;
            background: var(--accent);
            color: white;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            display: none;
            box-shadow: 0 3px 10px rgba(14, 14, 38, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .students-table th,
        .students-table td {
            padding: 12px 15px;
            text-align: right;
            border-bottom: 1px solid var(--gray-extra-light);
        }

        .students-table th {
            background-color: var(--primary-dark);
            color: white;
        }

        .students-table tr:nth-child(even) {
            background-color: var(--bg-very-light);
        }

        .students-table tr:hover {
            background-color: var(--bg-extra-light);
        }

        .view-toggle {
            text-align: center;
            margin: 20px 0;
        }

        .view-toggle button {
            padding: 8px 20px;
            background: var(--bg-very-light);
            border: none;
            border-radius: 20px;
            margin: 0 5px;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--text-medium);
            font-weight: 600;
        }

        .view-toggle button.active {
            background: var(--secondary);
            color: white;
        }

        footer {
            background: var(--primary-dark);
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
            border-top: 5px solid var(--accent);
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin: 30px 0;
            text-align: center;
            flex-wrap: wrap;
        }

        .stat-item {
            background: linear-gradient(135deg, var(--bg-white), var(--bg-extra-light));
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(14, 14, 38, 0.1);
            flex: 1;
            margin: 15px;
            min-width: 200px;
            border-top: 4px solid var(--secondary);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--secondary);
            margin-bottom: 10px;
        }

        .stat-title {
            color: var(--primary-dark);
            font-weight: 600;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background: var(--accent);
            color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(84, 156, 116, 0.3);
            transform: translateX(100%);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .notification.show {
            transform: translateX(0);
        }
    </style>
</head>

<body>
    <header>
        <div class="container header-content">
            <div class="logo-container">
                <div class="logo">
                    <img src="logo.png" alt="شعار الجامعة الإسلامية بغزة">
                </div>
                <div class="university-name">
                    الجامعة الإسلامية بغزة
                    <span>Islamic University of Gaza</span>
                </div>
            </div>
            <div class="academic-year">
                العام الأكاديمي: 2024/2025
            </div>
        </div>
    </header>

    <div class="container">
        <h1 class="main-title">نظام إدارة الطلاب</h1>

        <div class="stats">
            <div class="stat-item">
                <div class="stat-number"><?php echo $totalStudents; ?></div>
                <div class="stat-title">عدد الطلاب المسجلين</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo number_format($averageGPA, 1); ?></div>
                <div class="stat-title">متوسط المعدل التراكمي</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $maxGPA; ?></div>
                <div class="stat-title">أعلى معدل تراكمي</div>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="form-section">
                <h2 class="section-title">إضافة طالب جديد</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="name">اسم الطالب</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="id">رقم الهوية</label>
                        <input type="text" id="id" name="id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="gpa">المعدل التراكمي</label>
                        <input type="number" id="gpa" name="gpa" step="0.1" min="0" max="100" class="form-control"
                            required>
                    </div>
                    <button type="submit" name="add_student" class="btn btn-block">إضافة الطالب</button>
                </form>
            </div>

            <div class="students-section">
                <h2 class="section-title">قائمة الطلاب</h2>

                <form method="GET" action="" class="search-box">
                    <input type="text" name="search"
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
                        placeholder="ابحث باسم الطالب أو رقم الهوية...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>

                <div class="view-toggle">
                    <button id="cardViewBtn" class="active"><i class="fas fa-th-large"></i> عرض البطاقات</button>
                    <button id="tableViewBtn"><i class="fas fa-table"></i> عرض الجدول</button>
                </div>

                <div id="studentsContainer">
                    <?php if (count($searchResults) > 0): ?>
                        <?php foreach ($searchResults as $student): ?>
                            <div class="student-card">
                                <h3 class="student-name"><?php echo $student['name']; ?></h3>
                                <div class="student-details">
                                    <div class="student-detail">
                                        <i class="fas fa-id-card"></i>
                                        <span><?php echo $student['id']; ?></span>
                                    </div>
                                    <div class="student-detail">
                                        <i class="fas fa-envelope"></i>
                                        <span><?php echo $student['email']; ?></span>
                                    </div>
                                </div>
                                <div class="student-gpa">المعدل التراكمي: <?php echo $student['gpa']; ?></div>
                                <div class="student-rating"><?php echo getRating($student['gpa']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align: center; padding: 20px; color: var(--text-light)">لا توجد نتائج</div>
                    <?php endif; ?>
                </div>

                <table class="students-table" id="studentsTable">
                    <thead>
                        <tr>
                            <th>اسم الطالب</th>
                            <th>رقم الهوية</th>
                            <th>البريد الإلكتروني</th>
                            <th>المعدل التراكمي</th>
                            <th>التقييم</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchResults as $student): ?>
                            <tr>
                                <td><?php echo $student['name']; ?></td>
                                <td><?php echo $student['id']; ?></td>
                                <td><?php echo $student['email']; ?></td>
                                <td><?php echo $student['gpa']; ?></td>
                                <td><?php echo getRating($student['gpa']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>جميع الحقوق محفوظة &copy; 2025 - الجامعة الإسلامية بغزة</p>
            <p>نظام إدارة الطلاب - طلاب علم الحاسوب</p>
        </div>
    </footer>

    <?php if (isset($notification)): ?>
        <div class="notification show" id="notification"><?php echo $notification; ?></div>
        <script>
            setTimeout(() => {
                document.getElementById('notification').classList.remove('show');
            }, 3000);
        </script>
    <?php endif; ?>

    <script>

        document.getElementById('cardViewBtn').addEventListener('click', function () {
            this.classList.add('active');
            document.getElementById('tableViewBtn').classList.remove('active');
            document.getElementById('studentsContainer').style.display = 'block';
            document.getElementById('studentsTable').style.display = 'none';
        });

        document.getElementById('tableViewBtn').addEventListener('click', function () {
            this.classList.add('active');
            document.getElementById('cardViewBtn').classList.remove('active');
            document.getElementById('studentsContainer').style.display = 'none';
            document.getElementById('studentsTable').style.display = 'table';
        });
    </script>
</body>

</html>