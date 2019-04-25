<!DOCTYPE html>
<html>

<head>
    <title>My Feeds</title>
    <link href="/css/app.css" rel="stylesheet">
</head>

<body>

<link href="css/app.css" rel="stylesheet">
<div class="head-container">
    <div class="head">
        <div class="left">
            <h1> My Feeds </h1>
        </div>
        <div class="menu">
            <a href="/addFeed"><button> Add Feed </button></a>
        </div>

    </div>
</div>

<div class="container">
    <div class="feeds-container">

        <?php foreach ($entries as $entry): ?>
            <div class="feed">
                <div class="feed-header">
                    <h2>
                        <small><?= date('D, d M Y', strtotime($entry->updated)) ?></small>
                        <br/>
                        <a href="/feedReader/<?= htmlSpecialChars($entry->id) ?>">
                            <?= $entry->title ?>
                        </a>
                    </h2>
                </div>
                <div class="feed-body">
                        <div><?= $entry->summary ?></div>
                </div>
                <div class="feed-footer">
                    <a href="/feedReader/<?= htmlSpecialChars($entry->id) ?>">
                        read more
                    </a>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <div class="sidebar">
        <div class="recent-entries">
            <h2>Most Recent Entries</h2>
            <?php foreach ($entries->slice(0, 4) as $entry): ?>
                <div class="recent-entry">
                    <h3><a
                        href="/feedReader/<?= htmlSpecialChars($entry->id)?>"
                        alt="<?= $entry->title?>">
                        <?= $entry->title ?>
                    </a></h3>
                </div>
            <?php endforeach ?>
        </div>
        <div class="recent-feeds">
            <h2>Most Recent Feeds</h2>
            <?php foreach ($feeds->slice(0, 4) as $feed): ?>
                <div class="recent-feed">
                    <h3><a
                        href="#"
                        alt="<?= $feed->title ?>">
                        <?= $feed->title ?>
                    </a></h3>
                </div>
            <?php endforeach ?>
        </div>


    </div>
</div>
</body>
</html>