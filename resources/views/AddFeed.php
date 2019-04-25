<!DOCTYPE html>
<html>

<head>
    <title>Add Feed</title>
    <link href="/css/app.css" rel="stylesheet">
</head>

<body>
    <link href="css/app.css" rel="stylesheet">
    <div class="head-container">
        <div class="head">
            <div class="left">
                <h1> Add Feeds </h1>
            </div>
            <div class="menu">
                <a href="/feedReader"><button> View Feeds </button></a>
            </div>

        </div>
    </div>

    <?php if (isset($ok) && ($ok === 1)) { ?>
        <div class="success"> <h3>Feed Added Successfully</h3> </div>
    <?php } elseif(isset($ok)) { ?>
        <div class="fail"> <h3><?php $error ?></h3> </div>
    <?php } ?>

    <div class="add-feed">
        <form method="post">
            <label for="feed-link">Feed Link</label>
            <input name="feed-link" type="text">
            <label for="name">Name</label>
            <input name="name" type="text">
            <label for="email">Email</label>
            <input name="email" type="email">
            <button type="submit"> Save Feed</button>
        </form>
    </div>

</body>
</html>
