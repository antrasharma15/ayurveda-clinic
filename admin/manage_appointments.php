
<?php
include '../db.php';

// Fetch appointments
$sql = "SELECT a.*, d.name as doctor_name FROM appointments a LEFT JOIN doctors d ON a.doctor_id = d.id ORDER BY a.created_at DESC";
$result = $conn->query($sql);
$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
.appointments-section {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 2rem;
    background: var(--card);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}
.appointments-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
}
.appointments-header h2 {
    color: var(--accent-dark);
    margin: 0;
    font-size: 2rem;
}
.appointments-table-wrapper {
    overflow-x: auto;
}
.appointments-table {
    width: 100%;
    border-collapse: collapse;
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin-bottom: 1rem;
}
.appointments-table th, .appointments-table td {
    padding: 0.75rem 1rem;
    text-align: left;
}
.appointments-table th {
    background: var(--accent-light);
    color: var(--dark);
    font-weight: 600;
    border-bottom: 2px solid var(--accent);
}
.appointments-table tr {
    transition: background 0.2s;
}
.appointments-table tr:hover {
    background: var(--light);
}
.appointments-table td {
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}
.action-btns {
    display: flex;
    gap: 0.5rem;
}
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.4rem 0.7rem;
    border: none;
    border-radius: 6px;
    background: var(--accent-light);
    color: var(--dark);
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
    text-decoration: none;
}
.action-btn:hover {
    background: var(--accent);
    color: var(--white);
}
.action-btn.view { background: var(--accent-light); }
.action-btn.edit { background: #ffe082; color: var(--dark); }
.action-btn.edit:hover { background: #ffd54f; color: var(--dark); }
.action-btn.delete { background: #ffbdbd; color: var(--dark); }
.action-btn.delete:hover { background: #ff5252; color: var(--white); }
.action-btn.meet { background: #b2ebf2; color: var(--dark); }
.action-btn.meet:hover { background: #00bcd4; color: var(--white); }
@media (max-width: 768px) {
    .appointments-section {
        padding: 1rem;
    }
    .appointments-header h2 {
        font-size: 1.3rem;
    }
    .appointments-table th, .appointments-table td {
        padding: 0.5rem 0.5rem;
        font-size: 0.95rem;
    }
}
</style>

<div class="appointments-section">
    <div class="appointments-header">
        <h2><i class="fas fa-calendar-check"></i> Manage Appointments</h2>
        <!-- You can add a button for adding new appointments if needed -->
    </div>
    <div class="appointments-table-wrapper">
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Symptoms</th>
                    <th>Preferred Date</th>
                    <th>Doctor</th>
                    <th>Status</th>
                    <th>Assigned Time</th>
                    <th>Meet Link</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appt) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($appt['name']); ?></td>
                    <td><?php echo htmlspecialchars($appt['email']); ?></td>
                    <td><?php echo htmlspecialchars($appt['phone']); ?></td>
                    <td><?php echo htmlspecialchars($appt['symptoms']); ?></td>
                    <td><?php echo htmlspecialchars($appt['preferred_date']); ?></td>
                    <td><?php echo htmlspecialchars($appt['doctor_name'] ?? 'Not Assigned'); ?></td>
                    <td><?php echo htmlspecialchars($appt['status']); ?></td>
                    <td><?php echo htmlspecialchars($appt['assigned_time']); ?></td>
                    <td>
                        <?php if ($appt['meet_link']) { ?>
                            <a href="<?php echo htmlspecialchars($appt['meet_link']); ?>" class="action-btn meet" target="_blank" title="Join Meet"><i class="fas fa-video"></i></a>
                        <?php } else { echo 'N/A'; } ?>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="view_appointment.php?id=<?php echo $appt['id']; ?>" class="action-btn view" title="View"><i class="fas fa-eye"></i></a>
                            <a href="edit_appointment.php?id=<?php echo $appt['id']; ?>" class="action-btn edit" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="delete_appointment.php?id=<?php echo $appt['id']; ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure you want to delete this appointment?');"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
