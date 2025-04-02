<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fake Airbnb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="images/house-heart-fill.svg">
    <link rel="mask-icon" href="images/house-heart-fill.svg" color="#000000">

</head>

<body>

    <header>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4">
                        <h4 class="text-white">About</h4>
                        <p class="text-muted">Fake Airbnb. Data c/o http://insideairbnb.com/get-the-data/</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="index.php" class="navbar-brand d-flex align-items-center">
                    <i class="bi bi-house-heart-fill my-2"></i>
                    <strong> Fake Airbnb</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </header>

    <main>

        <div class="album py-5 bg-light">
            <div class="container">
                <h1>Search for rentals in the Portland area:</h1>
                <form action="results.php" method="get" id="airBnbForm">
                    <div class="">

                        <label for="neighborhood" class="d-inline-block form-label">Neighborhood</label>
                        <div class="container w-25 d-inline-block">
                            <select class="form-select d-inline-block width:auto" aria-label="Default select example" name="neighborhood" id="neighborhood">
                                <option selected>Any</option>
                                
                                <?php
                                include "src/functions.php";
                                $conn = dbConnect();
                                $sql = 'select * from neighborhoods;';
                                $sth = $conn->prepare($sql);
                                $sth->execute();
                                foreach ($sth->fetchAll() as $row) {
                                    print '<option value="' . $row['id'] . '">' . $row['neighborhood'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>


                    </div><!-- row -->
                    <div class="">

                        <label for="room" class="d-inline-block form-label">Room Type</label>
                        <div class="container w-25 d-inline-block">
                            <select class="form-select d-inline-block width:auto" aria-label="Default select example" name="room" id="room">
                                <option selected>Any</option>
                                <?php
                                
                                
                                $sql = 'select * from roomTypes;';
                                $sth = $conn->prepare($sql);
                                $sth->execute();
                                foreach ($sth->fetchAll() as $row) {
                                    print '<option value="' . $row['id'] . '">' . $row['type'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="">
                            <label for="guests" class="d-inline-block form-label">Number of Guests:</label>
                            <div class="container w-25 d-inline-block">
                                <select class="form-select d-inline-block width:auto" name="guests" id="guests">
                                    <?php
                                    foreach (range(1, 10) as $i) {
                                        echo "<option value='$i'>$i</option>";
                                    };
                                    ?>
                                </select>
                            </div>


                        </div><!-- row -->

                    </div><!-- row -->
                    <input class="btn btn-primary col col-sm-auto mx-2" type="submit" value="Submit">
                </form>
            </div><!-- .container-->
        </div><!-- album-->

    </main>

    <footer class="text-muted py-5">
        <div class="container">

            <p class="mb-1">CS 293, Spring 2025</p>
            <p class="mb-1">Lewis & Clark College</p>
        </div><!-- .container-->
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
</body>

</html>