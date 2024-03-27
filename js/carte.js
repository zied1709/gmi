var fav = document.getElementsByName("fav[]");

function checkTest1(th) {

	var flag = th.checked;

	for (var i in fav) {
		fav[i].checked = flag;
	}
}

function checkTest2() {
	var flag = true;
	for (var i = 1; i < fav.length - 1; i++) {
		if (!fav[i].checked) {
			flag = false;
			break;
		}
	}

	fav[0].checked = flag;
	fav[fav.length - 1].checked = flag;

	var total = 0;
	var num = 0;
	var spNum = 0;

	for (var i = 1; i < fav.length - 1; i++) {
		if (fav[i].checked) {
			num++;
			var par = fav[i].parentNode.parentNode;
			var td = par.getElementsByTagName("td");
			var t = td[6].innerText.split("$")[1];

			total += Number(t);
			document.getElementById("total").innerText = total;

			var t2 = td[5].getElementsByTagName("input");
			var num2 = t2[0].value;
			spNum += Number(num2);
			document.getElementById("snum").innerText = spNum;

			console.log(t);
			console.log(total);
			console.log(num2);
			console.log(snum);

		}
	}
	if (num == 0) {
		document.getElementById("total").innerText = 0;
		document.getElementById("snum").innerText = 0;
	}
}

function checkTest3(th, sig) {
	var pre;
	if (sig == "1") {
		pre = th.nextElementSibling;
		if (Number(pre.value) > 0) {
			pre.value = Number(pre.value) - 1;
		}
	} else {
		pre = th.previousElementSibling;
		pre.value = Number(pre.value) + 1;
	}

	var val = pre.parentNode.previousElementSibling.innerText;
	var total = Number(val) * Number(pre.value)
	pre.parentNode.nextElementSibling.innerText =total;
}

function checkTest4(th) {
	var div = th.parentNode.parentNode.parentNode;
	div.remove();
}

function startTimer(duration, display) {
	var timer = duration, minutes, seconds;
	setInterval(function () {
		minutes = parseInt(timer / 60, 10);
		seconds = parseInt(timer % 60, 10);

		minutes = minutes < 10 ? "0" + minutes : minutes;
		seconds = seconds < 10 ? "0" + seconds : seconds;

		display.textContent = minutes + ":" + seconds;

		if (--timer < 0) {
			for (var i = 1; i < (fav.length + 1); i++) {
				var div = document.getElementById("info warp");
				var div2 = document.getElementById("hr-cart");
				var div3 = document.getElementById("check-cart");
				var div4 = document.getElementById("thead-cart");
				
				
				div.remove();
				div2.remove();
				div3.remove();
				div4.remove();

				document.getElementById("notification").innerHTML ='<div class="block text-center" style="    margin-top: -50px;"><i style="font-size:50px" class="tf-ion-ios-cart-outline"></i><h2 class="text-center">Your cart is currently empty.</h2><p>Go Fast Fill Your Cart . Have A Nice Shopping ! </p><a href="products.php" class="btn btn-main mt-20">Return to shop</a></div>';

				
				createCookie("empty", 1 , "10");

				var delayInMilliseconds = 6000; //6 second

				setTimeout(function() {
					window.location = "products.php";
				}, delayInMilliseconds);
			}
		}
	}, 1000);
}

window.onload = function () {
	var time = 60 * 1;
	display = document.querySelector('#time');
	startTimer(time, display);
}

function placeorder() {
	if (document.getElementById("snum").innerText == 0) {
		window.alert("Please select at least one item");
	} else {
		window.alert("We have received your order! \n Order processing...");
	}
}

// Function to create the cookie
function createCookie(name, value, days) {
    var expires;

    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toGMTString();
    } else {
      expires = "";
    }

    document.cookie = escape(name) + "=" +
      escape(value) + expires + "; path=/";
  }

