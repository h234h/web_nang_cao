<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<h1>Employee List</h1>
<a href="index.php?url=admin/Employee/create" class="btn btn-primary">Add Employee</a>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($employees as $emp): ?>
        <tr>
            <td><?= $emp["id_user"] ?></td>
            <td><?= htmlspecialchars($emp["username"]) ?></td>
            <td><?= htmlspecialchars($emp["fullname"]) ?></td>
            <td><?= htmlspecialchars($emp["email"]) ?></td>
            <td><?= htmlspecialchars($emp["phone"]) ?></td>
            <td>
                <?= $emp["status"] == 1 ? "<span style='color:green'>Active</span>" : "<span style='color:red'>Locked</span>" ?>
            </td>
            <td>
                <a href="index.php?url=admin/Employee/edit/<?= $emp['id_user'] ?>">Edit</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>