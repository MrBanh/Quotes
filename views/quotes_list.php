<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>Tony Banh - Quotes Project</title>
</head>
<body class="container py-4">
    <!-- Form -->
    <form action="." method="get">
        <div class="form_group_container d-flex row justify-content-center">
            <div class="form_group col-lg-2 d-flex justify-content-center align-items-center my-2">
                <label class="form_label" for="authorId" aria-label="Filter by author"></label>
                <select class="form_input form-select" name="authorId" id="authorId">
                    <option value="" <?= (!$authorId ? 'selected' : '') ?>>View All Authors</option>

                    <?php foreach($authors as $author) {?>
                        <option
                        value="<?= $author['id'] ?>"
                        <?= (isset($authorId) && $authorId == $author['id'] ? 'selected' : '') ?>
                        ><?= $author['author'] ?></option>
                    <?php } ?>

                </select>
            </div>

            <div class="form_group col-lg-2 d-flex justify-content-center align-items-center my-2">
                <label class="form_label" for="categoryId" aria-label="Filter by category"></label>
                <select class="form_input form-select" name="categoryId" id="categoryId">
                    <option value="" <?= (!$categoryId ? 'selected' : '') ?>>View All Categories</option>

                    <?php foreach($categories as $category) {?>
                        <option
                        value="<?= $category['id'] ?>"
                        <?= (isset($categoryId) && $categoryId == $category['id'] ? 'selected' : '') ?>
                        ><?= $category['category'] ?></option>
                    <?php } ?>

                </select>
            </div>

            <div class="form_group col-lg-2 d-flex justify-content-center align-items-center my-2">
                <button class="btn btn-outline-primary mx-1"type="submit">Submit</button>
                <a href="." class="btn btn-outline-danger mx-1" role="button" aria-pressed="false" aria-label="Reset filters">Reset</a>
            </div>
        </div>
    </form>

    <!-- Quotes List -->
    <?php if (count($quotes) > 0) { ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 py-2">
            <?php foreach($quotes as $quote) { ?>
                <div class="p-3">
                    <div class="card col h-100">
                        <div class="card-body d-flex flex-column align-items-stretch justify-content-between">
                            <h4 class="quote text-center"><q><?= $quote['quote'] ?></q></h4>
                            <div class="author text-end">- <?= $quote['author'] ?></div>
                        </div>

                        <div class="category card-footer bg-transparent d-flex justify-content-end align-items-center">
                            <span class="badge rounded-pill bg-primary ms-2"><?= $quote['category'] ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="d-flex justify-content-center align-items-center py-2">
            <p>No Quotes Found</p>
        </div>
    <?php } ?>

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>