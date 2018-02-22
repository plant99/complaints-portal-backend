<?php use App\Http\Controllers\ComplaintController;?>
        <!DOCTYPE html>
<html>
<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC|Rambla" rel="stylesheet">

    <script type="text/javascript" src="js/jquery.js"></script>
    <title>Dashboard</title>
</head>
<body>
<div class="topbar row">
    <h2 class="col-sm-8"> Complaints Portal</h2>
    <select  class="category-filter col-sm-2">
        <option value="all">all</option>
        <option value="WAITING">waiting</option>
        <option value="PENDING">pending</option>
        <option value="RESOLVED">resolved</option>
    </select>
</div>


<span class="col-sm-1"></span>
<div class="complaints-container row">

</div>



<script type="text/javascript" src="js/dashboard.js"></script>

<script type="text/javascript">
    let dummyJsonData = {
        complaints: [
            {
                id: 1,
                author: "Hey there",
                title: "lol",
                description: "Not bad",
                status: "WAITING"
            },
            {
                id: 2,
                author: "Hey there",
                title: "lol",
                description: "Sure lorem ipsum dolor aledasojdoaiu djsdfoigayergyeiu oiufdsygiueryguie rguieyrgu  safiyasyfweytiurew yuiowh uivu sdhfgiudfsugiuerytiuteryd",
                status: "PENDING"
            },
            {
                id: 3,
                author: "Hey there",
                title: "lol",
                description: "Not bad",
                status: "RESOLVED"
            },
            {
                id: 3,
                author: "Hey there",
                title: "lol",
                description: "Not bad",
                status: "RESOLVED"
            },
            {
                id: 3,
                author: "Hey there",
                title: "lol",
                description: "Not bad",
                status: "RESOLVED"
            }
        ]
    }
    $('.category-filter').change(e => {
        let statusValue = $(".category-filter").val();
    if(statusValue == "all"){
        renderComplaints(dummyJsonData.complaints);
        return;
    }else{
        let complaints = dummyJsonData.complaints;
        let newComplaints = complaints.filter((el) => {
            console.log(el.status, statusValue);
        return el.status === statusValue;
    })
        console.log(newComplaints);
        renderComplaints(newComplaints);
    }
    })
    renderComplaints(dummyJsonData.complaints);
    function renderComplaints(complaints){
        let complaintsContainer = document.querySelector('.complaints-container');
        let complaintsContainerHTML = "";
        complaintsContainer.innerHTML = "";
        for(i in complaints){
            let complaint = complaints[i];
            let complaintHtml = returnComplaintCard(complaint.id, complaint.title, complaint.description.slice(0, 50));
            complaintsContainerHTML += complaintHtml;
        }
        complaintsContainer.innerHTML = complaintsContainerHTML;
        let modifyButtons = document.querySelectorAll('.modify');
        for(i in modifyButtons){
            let modifyButton = modifyButtons[i];
            if(modifyButton){
                modifyButton.onclick = function(e){
                    let id = Number(e.target.getAttribute('data-id'));
                    let requiredComplaint = complaints[0];
                    for(i in complaints){
                        if(complaints[i].id === id){
                            requiredComplaint = complaints[i];
                        }
                    }
                    let modalHtml = returnModalHtml(requiredComplaint.id, requiredComplaint.title, requiredComplaint.description, requiredComplaint.status);
                    let divTBA = document.createElement('div');
                    divTBA.setAttribute('class', 'tempDIV');
                    divTBA.innerHTML = modalHtml;
                    document.body.appendChild(divTBA);
                    $('.close-custom').click(e => {
                        document.body.removeChild(divTBA);
                })
                }
            }
        }
    }

    function returnModalHtml(id, title, details, status){
        let html = `
				<div class="modal-custom">
					<div class="display row">
						<p class="col-lg-2"></p>
						<form class="col-lg-8" data-id="${id}" onSubmit="${changeStatus(id, status)}">
							<h1>${title}</h1>
							<p>
								${details}
							</p>
							<select name="status" value="${status}"  class="status col-sm-2">
					      <option value="waiting">waiting</option>
					      <option value="pending">pending</option>
					      <option value="resolved">resolved</option>
						  </select>
						  <br>
						  <p>&nbsp;</p>
						  <div class="row">
						  	<p class="col-md-5"></p>
						  	<button name="submit" class="submit btn col-md-1 btn-primary">Save</button>
						  	<button class="close-custom btn col-md-1 btn-primary">Close</button>
						  </div>
						</form>
					</div>
				</div>
			`;
        return html;
    }

    function returnComplaintCard(id, title, shortDetails){
        let complaintCardHtml = `
				<div class="col-sm-4">
			    <div class="card" data-id="${id}">
			      <div class="card-block">
			        <h3 class="card-title">${title}</h3>
			        <p class="card-text">${shortDetails}</p>
			        <button data-id="${id}" class="btn btn-primary modify">Modify</button>
			      </div>
			    </div>
			  </div>
			`;
        return complaintCardHtml;
    }

    $.ajax({
        type: "GET",
        url: '/get_all_complaints',
        success: function(data) {
            console.log(data);
        }
    })
</script>
</body>
</html>