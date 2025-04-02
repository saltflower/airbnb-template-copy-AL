// javascript goes here
buttons = document.getElementsByClassName("viewListing");

console.log(buttons);
Object.values(buttons).forEach(element => { element.addEventListener("click", onViewListing); });

async function onViewListing(e) {
    let targetId = e.target.id;
    let data;
    $.ajax({
        url: '../src/ajax.php',
        type: 'GET',
        data: {id: targetId,
               action: "getData"
        },
        success: function(response) {
            console.log("Raw response:", response); // Log the raw response
            data = response;
            try {
                if (data.error) {
                    console.error(data.error);
                } else {
                    document.getElementById("modal-title").innerText = data['name'];
                    document.getElementById("modal-image-src").setAttribute("src", data['pictureUrl']);
                    document.getElementById("neighborhood").textContent = data['neighborhood'] + " neighborhood";
                    document.getElementById("price").textContent = "$" + data['price'] + " / night";
                    document.getElementById("accommodates").textContent = "Accommodates " + data['accommodates'];
                    document.getElementById("rating").innerHTML = '<i class="bi bi-star-fill"></i> ' + data['rating'];
                    document.getElementById("host").textContent = "Hosted by " + data['hostName'];
                }
            } catch (e) {
                console.error("Invalid JSON:", e);
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
    $.ajax({
        url: '../src/ajax.php',
        type: 'GET',
        data: {id: targetId,
               action: "getAmenities"
        },
        success: function(response) {
            console.log("Raw response:", response); // Log the raw response
            data = response;
            try {
                if (data.error) {
                    console.error(data.error);
                } else {
                    let a = "";
                    for (let i = 0; i < data.length; i++) {
                        if (i != 0) {
                            a += ", ";
                        }
                        a += data[i];
                    }
                    document.getElementById("amenities").textContent = "Amenities: " + a;
                }
            } catch (e) {
                console.error("Invalid JSON:", e);
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
    
}