<?php include 'partials/header.php'; ?>
    <h5>Contact List</h5>

    <form method="POST" action="" class="form-inline float-right">
        <input type="text" class="form-control mb-2 mr-sm-2" id="name" name="name" placeholder="Search by name">
        <input type="text" class="form-control mb-2 mr-sm-2" id="surname" name="surname" placeholder="Search by surname">
        <input type="text" class="form-control mb-2 mr-sm-2" id="telephone" name="telephone" placeholder="Search by telephone">
        <input type="text" class="form-control mb-2 mr-sm-2" id="email" name="email" placeholder="Search by email">

        <button type="submit" class="btn btn-primary mb-2">Search</button>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Telephone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?= htmlspecialchars($contact->getId()) ?></td>
                <td><?= htmlspecialchars($contact->getName()) ?></td>
                <td><?= htmlspecialchars($contact->getSurname()) ?></td>
                <td><?= htmlspecialchars($contact->getTelephone()) ?></td>
                <td><?= htmlspecialchars($contact->getEmail()) ?></td>
                <td><?= htmlspecialchars($contact->getAddress()) ?></td>
                <td>
                    <form method="POST" action="/delete" onsubmit="return confirm('Are you sure you want to delete this contact?');">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($contact->getId()) ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php include 'partials/footer.php'; ?>