/* DOM elements */

const statusFilterSelect = document.querySelector("select#status-filter");

/* Functions */

function handleStatusQueryParameter() {
	const statusValue = statusFilterSelect.value;

	const urlSearchParams = new URLSearchParams(window.location.search);

	if (statusValue) {
		urlSearchParams.set("status", statusValue);
	} else {
		urlSearchParams.delete("status");
	}

	// Avoid errors with paging
	urlSearchParams.delete("page");

	window.location.search = urlSearchParams;
}

/* Event listeners */

statusFilterSelect.addEventListener("change", handleStatusQueryParameter);
