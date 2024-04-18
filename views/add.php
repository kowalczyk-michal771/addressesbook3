<?php include 'partials/header.php'; ?>

    <h2>Add Contact</h2>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger" role="alert">
        <?php
            foreach($errors as $value) {
                echo $value.'<br/>';
            }
        ?>
    </div>
    <?php endif; ?>

    <form action="/add" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="surname">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname" required>
        </div>
        <div class="form-group">
            <label for="telephone">Telephone</label>
            <input type="text" class="form-control" id="telephone" name="telephone" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="address">Physical Address</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Contact</button>
    </form>

<?php include 'partials/footer.php'; ?>