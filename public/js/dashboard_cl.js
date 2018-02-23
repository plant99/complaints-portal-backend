let dummyJsonData = {};
function loadTickets() {
    $.ajax({
        type: "GET",
        url: '/get_user_complaints',
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
				let complaintHtml = returnComplaintCard(complaint.id, complaint.title, complaint.content, complaint.status);
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
						let modalHtml = returnModalHtml(requiredComplaint.id, requiredComplaint.title, requiredComplaint.content, requiredComplaint.status);
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
		function statusToClassName(status){
			if(status === "WAITING") return "s_waiting";
			if(status === "PENDING") return "s_pending";
			if(status === "RESOLVED") return "s_resolved";
		}
		function returnModalHtml(id, title, details, status){
			let html = `
				<div class="modal-custom">
					<div class="display row">
						<p class="col-lg-2"></p>
						<form class="col-lg-8" data-id="${id}">
							<h1>${title}</h1>
							<p>
								${details}
							</p>
							<h3>Status</h3>  <p> ${status}</p>
						  <br>
						  <p>&nbsp;</p>
						  <div>
						  	<button class="close-custom btn col-md-2 btn-primary">Close</button>
						  </div>
						</form>
					</div>
				</div>
			`;
			return html;
		}
		function returnComplaintCard(id, title, shortDetails, status){
			let complaintCardHtml = `
				<div class="col-sm-4">
			    <div class="card ${statusToClassName(status)}" data-id="${id}">
			      <div class="card-block">
			        <h3 class="card-title">${title}</h3>
			        <textarea readonly class="card-text complaint-text">${shortDetails}</textarea>
			        <button data-id="${id}" class="btn btn-primary modify">View</button>
			      </div>
			    </div>
			  </div>
			`;
			return complaintCardHtml;
		}
		loadTickets();