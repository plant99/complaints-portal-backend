let dummyJsonData = {};
$('.category-filter').change(e => {
	let statusValue = $(".category-filter").val();
	if(statusValue == "all"){
		renderComplaints(dummyJsonData.complaints);
		return;
	}else{
		let complaints = dummyJsonData.complaints;
		let newComplaints = complaints.filter((el) => {
			return el.status === statusValue;
		})
		renderComplaints(newComplaints);
	}
})
function renderComplaints(complaints){
	console.log(complaints);
	let complaintsContainer = document.querySelector('.complaints-container');
	let complaintsContainerHTML = "";
	complaintsContainer.innerHTML = "";
	for(i in complaints){
		let complaint = complaints[i];
		let complaintHtml = returnComplaintCard(complaint.id, complaint.title, complaint.content, complaint.status, complaint.username);
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
				let modalHtml = returnModalHtml(requiredComplaint.id, requiredComplaint.title, requiredComplaint.content, requiredComplaint.status, requiredComplaint.url);
				let divTBA = document.createElement('div');
				divTBA.setAttribute('class', 'tempDIV');
				divTBA.innerHTML = modalHtml;
				document.body.appendChild(divTBA);

	
				$('.update-complaint').click((e) => {
					let id = $(e.target).attr('data-id');
					let status = $('.modal-custom .status').val();
					updateComplaintStatus(status, id);
					document.body.removeChild(divTBA);
					setTimeout(function(){
						location.reload();
					}, 1000);
				});
				$('.close-custom').click(e => {
					document.body.removeChild(divTBA);
				});
			}
		}
	}
}
function returnModalHtml(id, title, details, status, url){
	let html = `
		<div class="modal-custom">
			<div class="display row">
				<p class="col-lg-2"></p>
				<div class="col-lg-8" data-id="${id}">
					<h1>${title}</h1>
					<p class="complaint_text">
						${details}
					</p>

				  <p>Related Link <a href="${url}">LINK</a> </p>
					<select name="status" value="${status}"  class="status col-sm-3">
			      <option value="WAITING">waiting</option>
			      <option value="PROCESSING">processing</option>
			      <option value="RESOLVED">resolved</option>
				  </select>
				  <br>
				  <p>&nbsp;</p>
				  <div class="row">
				  	<p class="col-md-4"></p>
				  	<button data-id="${id}" name="submit"  class="update-complaint btn col-md-2 btn-primary">Save</button>
				  	<button class="close-custom btn col-md-2 btn-primary">Close</button>
				  </div>
				</div>
			</div>
		</div>
	`;
	return html;
}
function statusToClassName(status){
	console.log(status);
	if(status === "WAITING") return "s_waiting";
	if(status === "PROCESSING") return "s_processing";
	if(status === "RESOLVED") return "s_resolved";
}
function returnComplaintCard(id, title, shortDetails, status, author){
	let complaintCardHtml = `
		<div class="col-sm-4 ">
	    <div class="card ${statusToClassName(status)}" data-id="${id}">
	      <div class="card-block ">
	        <h3 class="card-title">${title}</h3>
	        <p>By ${author}</p>
	        <textarea readonly class="card-text complaint-text">${shortDetails}</textarea>
	        <br>
	        <br>
	        <button data-id="${id}" class="btn btn-primary modify">Modify</button>
	      </div>
	    </div>
	  </div>
	`;
	return complaintCardHtml;
}

function loadTickets() {
    $.ajax({
        type: "GET",
        url: '/get_all_complaints',
        success: function(data) {
            var complaints = JSON.parse(data);
            complaints = complaints.filter(complaint => {
            	if(complaint.status == 'Registered'){
            		complaint.status = "WAITING";
            	}
            	if(complaint.status == 'Processing'){
            		complaint.status = "PROCESSING";
            	}
            	if(complaint.status == 'Resolved'){
            		complaint.status = "RESOLVED";
            	}
            	return complaint;
            })
            dummyJsonData.complaints = complaints;
						renderComplaints(dummyJsonData.complaints);
        }
    })
}

function loadTicketsFilter(status) {
    $.ajax({
        type: "POST",
        url: '/get_status_complaints',
        data: {
            'status': status
        },
        success: function(data) {
            var complaints = JSON.parse(data);
            dummyJsonData.complaints = complaints;
        }
    })
}
function updateComplaintStatus(status, id){
	$.ajax({
      type: "POST",
      url: '/update_complaint_status',
      data: {
          'complaint_status': status,
          'complaint_id': id
      },
      success: function(data) {
          data = JSON.parse(data);
          console.log(data);
      }
  });
}

loadTickets();