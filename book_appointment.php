<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $symptoms = $_POST['symptoms'];
    $preferred_date = $_POST['preferred_date'];
    $doctor_id = $_POST['doctor_id'];

    $sql = "INSERT INTO appointments (name, email, phone, symptoms, preferred_date, doctor_id) VALUES ('$name', '$email', '$phone', '$symptoms', '$preferred_date', $doctor_id)";
    if ($conn->query($sql) === TRUE) {
        $message = "Appointment booked successfully! You will receive a confirmation once the doctor assigns a time.";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch doctors
$sql = "SELECT * FROM doctors";
$result = $conn->query($sql);
$doctors = [];
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Book Appointment — Sikhar Ayurveda Clinic</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <?php include 'header.php'; ?>

  <main id="main-content">
    <section class="section-wrapper">
      <div class="content-container">
        <h1>Book Your Appointment</h1>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>

        <h2>Select a Doctor</h2>
        <div class="grid">
          <?php foreach ($doctors as $doctor) { ?>
            <div class="card">
              <h3><?php echo $doctor['name']; ?></h3>
              <p>Specialization: <?php echo $doctor['specialization']; ?></p>
              <p>Email: <?php echo $doctor['email']; ?></p>
              <p>Phone: <?php echo $doctor['phone']; ?></p>
              <button onclick="selectDoctor(<?php echo $doctor['id']; ?>, '<?php echo $doctor['name']; ?>')">Select This Doctor</button>
            </div>
          <?php } ?>
        </div>

        <div id="bookingForm" style="display:none;">
          <h2>Book with <span id="selectedDoctor"></span></h2>
          <form method="POST" style="max-width: 600px; margin: 0 auto;">
            <input type="hidden" name="doctor_id" id="doctor_id">
            <input type="text" name="name" placeholder="Full Name" required style="width: 100%; padding: 10px; margin: 10px 0;">
            <input type="email" name="email" placeholder="Email" required style="width: 100%; padding: 10px; margin: 10px 0;">
            <input type="tel" name="phone" placeholder="Phone Number" required style="width: 100%; padding: 10px; margin: 10px 0;">
            <textarea name="symptoms" placeholder="Describe your symptoms or concerns" required style="width: 100%; padding: 10px; margin: 10px 0; height: 100px;"></textarea>
            <input type="date" name="preferred_date" required style="width: 100%; padding: 10px; margin: 10px 0;">
            <button type="submit" style="width: 100%; padding: 10px; background: #7aa67a; color: white; border: none; border-radius: 5px;">Book Appointment</button>
          </form>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="footer-content">
      <div class="footer-bottom">
        <p>© <?php echo date('Y'); ?> Sikhar Ayurveda Clinic. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
    function selectDoctor(id, name) {
      document.getElementById('doctor_id').value = id;
      document.getElementById('selectedDoctor').textContent = name;
      document.getElementById('bookingForm').style.display = 'block';
    }
  </script>
  <script src="js/main.js"></script>
</body>
</html>
