/* DOM element(s) */

const deleteConfirmBtn = document.querySelector("#delete-confirm");
const confirmModal = document.querySelector("#confirm-modal");
const cancelButton = document.querySelector("#cancel-delete");
const sectionTag = document.querySelector("section");

/* Function(s) */

function displayConfirmModal() {
	confirmModal.setAttribute("aria-hidden", false);
	sectionTag.setAttribute("aria-hidden", true);

	confirmModal.classList.remove("hidden");
	confirmModal.classList.add("flex");

	// smooth transition
	setTimeout(() => {
		confirmModal.classList.remove("opacity-0");
	}, 100);
}

function hideConfirmModal() {
	confirmModal.classList.add("opacity-0");

	// smooth transition
	setTimeout(() => {
		confirmModal.classList.remove("flex");
		confirmModal.classList.add("hidden");

		confirmModal.setAttribute("aria-hidden", true);
		sectionTag.setAttribute("aria-hidden", false);
	}, 250);
}

/* Event listeners */

deleteConfirmBtn.addEventListener("click", displayConfirmModal);
cancelButton.addEventListener("click", hideConfirmModal);
confirmModal.addEventListener("click", event => {
	if (event.currentTarget == event.target) {
		hideConfirmModal();
	}
});
