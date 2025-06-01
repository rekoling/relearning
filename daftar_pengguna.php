<?php
require 'koneksi.php';

$result = $conn->query("SELECT * FROM users");

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['username']}</td>
        <td>{$row['email']}</td>
        <td><span class='badge " . ($row['role'] === 'mahasiswa' ? 'bg-primary' : 'bg-warning text-dark') . "'>" . ucfirst($row['role']) . "</span></td>
        <td><span class='badge " . ($row['status'] === 'active' ? 'bg-success' : 'bg-secondary') . "'>" . ucfirst($row['status']) . "</span></td>
        <td>
            <button class='btn btn-sm btn-outline-primary'><i class='bi bi-eye'></i></button>
            <button class='btn btn-sm btn-outline-secondary'><i class='bi bi-pencil'></i></button>
        </td>
    </tr>";
}
?>
