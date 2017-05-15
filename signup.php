<?php require_once "header.php"?>

    <div class="container" >
        <div class="row">
            <h3>Inscription</h3>
            <div class="col-lg-4 col-lg-offset-4">
                <form action="signup.php" method="POST" autocomplete="off" >

                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" >
                    </div>
                    <div class="form-group">
                        <label for="">Mot de passe : </label>
                        <input type="password" class="form-control" name="password" placeholder="Mot de passe" >
                    </div>
                    <div class="form-group">
                        <label for="">Type</label>
                        <select name="type" class="form-control" >
                            <option value="etudiant">Etudiant</option>
                            <option value="professeur">Professeur</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="signup" class="btn btn-success btn-lg" > S'inscrire </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

<?php require_once "footer.php" ?>