<!DOCTYPE html>
<html lang="us">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Register Complaint</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/complaint.css">
</head>
<body>
<div id="complaint-page">
    <div class="topbar">
        <img src="images/header.png"/>
    </div>
    <form class="form row">
        <p id="toaster"></p>
        <input name="title" type="text" id="title" placeholder="Title of the change required"/>
        <input name="linked_url" id="url" type="text" placeholder="Linked URL"/>
        <textarea class="col-lg-12" id="content" name="details" type="text" placeholder="Enter details of the update"></textarea>
        <p>&nbsp;</p>
        <button id="submit" type="submit" class="col-lg-12">Submit</button>
    </form>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/slider.js"></script>
<script>
    $("#submit").click((e) => {
        e.preventDefault();
        var title = $("#title").val();
        $("#title").val('')
        var content = $("#content").val();
        $("#content").val('');
        let url = $("#url").val();
        $.ajax({
            type: "POST",
            url: '/create_complaint',
            data: {
                'title': title,
                'content': content,
                'url': url
            },
            success: function(data) {
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
</script>
</body>
</html>