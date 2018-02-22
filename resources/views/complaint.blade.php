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
    <form class="form row">
        <p id="toaster"></p>
        <input name="title" type="text" id="title" placeholder="Title of the complaint"/>
        <textarea class="col-lg-12" name="details" id="content" type="text" placeholder="Enter complaint details"></textarea>
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
        var content = $("#content").val();
        $.ajax({
            type: "POST",
            url: '/create_complaint',
            data: {
                'title': title,
                'content': content
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