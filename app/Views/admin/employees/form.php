<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<link rel="stylesheet" href="public/assets/css/admin/employee.css" />

<h1><?= $employee ? "Edit Employee" : "Add Employee" ?></h1>

<form action="index.php?url=admin/Employee/save" method="post" class="emp-form">
    <input type="hidden" name="id" value="<?= $employee["id_user"] ?? "" ?>">

    <?php if (!empty($error)): ?>
        <div class="alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <label>Username</label>
    <input type="text" name="username" value="<?= htmlspecialchars($employee["username"] ?? "") ?>" required>

    <label>Password <?= $employee ? "(leave blank to keep current)" : "" ?></label>
    <input type="password" name="password">

    <label>Full Name</label>
    <input type="text" name="fullname" value="<?= htmlspecialchars($employee["fullname"] ?? "") ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($employee["email"] ?? "") ?>">

    <label>Phone</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($employee["phone"] ?? "") ?>">

    <label>Address</label>
    <input type="text" name="address" value="<?= htmlspecialchars($employee["address"] ?? "") ?>">

    <label>Status</label>
    <select name="status">
        <option value="1" <?= ($employee["status"] ?? 1) == 1 ? "selected" : "" ?>>Active</option>
        <option value="0" <?= ($employee["status"] ?? 1) == 0 ? "selected" : "" ?>>Locked</option>
    </select>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="index.php?url=admin/Employee/index" class="btn btn-ghost">Back</a>
    </div>
</form>