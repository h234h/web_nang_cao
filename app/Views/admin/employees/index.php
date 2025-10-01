<?php require_once __DIR__ . "/../layouts/header.php"; ?>
<link rel="stylesheet" href="public/assets/css/admin/employee.css" />

<h1>Employee List</h1>
<a href="index.php?url=admin/Employee/create" class="btn btn-primary">Add Employee</a>

<table class="employee-table" border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $emp): ?>
            <tr>
                <td><?= $emp["id_user"] ?></td>
                <td><?= htmlspecialchars($emp["username"]) ?></td>
                <td><?= htmlspecialchars($emp["fullname"]) ?></td>
                <td><?= htmlspecialchars($emp["email"]) ?></td>
                <td><?= htmlspecialchars($emp["phone"]) ?></td>
                <td>
                    <?php if ($emp["status"] == 1): ?>
                        <span class="status-badge status-active">Active</span>
                    <?php else: ?>
                        <span class="status-badge status-locked">Locked</span>
                    <?php endif; ?>
                </td>
                <td class="col-actions">
                    <a href="index.php?url=admin/Employee/edit/<?= $emp['id_user'] ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>