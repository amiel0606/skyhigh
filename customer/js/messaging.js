document.addEventListener("DOMContentLoaded", function () {
  const messageInput = document.getElementById("messageInput");
  const sendButton = document.getElementById("sendButton");
  const imageButton = document.getElementById("imageButton");
  const imageInput = document.getElementById("imageInput");
  const chatMessages = document.querySelector(".chat-messages");

  function appendMessageHTML(content, isImage = false) {
    const messageContainer = document.createElement("div");
    messageContainer.className = "message-container";
    messageContainer.innerHTML = `
            <p class="my-message has-background-primary">
                <strong>You:</strong> ${
                  isImage
                    ? `<img src="${content}" style="max-width: 200px; border-radius: 10px;">`
                    : content
                }
            </p>`;
    chatMessages.appendChild(messageContainer);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  function sendMessage(imageFile = null) {
    const text = messageInput.value.trim();

    // Prevent sending empty text unless there's an image
    if (text === "" && !imageFile) return;

    const formData = new FormData();
    formData.append("message", text);
    formData.append("type", imageFile ? "image" : "text");

    if (imageFile) {
      formData.append("image", imageFile);
      appendMessageHTML(URL.createObjectURL(imageFile), true);
    } else {
      appendMessageHTML(text, false);
    }

    messageInput.value = "";

    axios
      .post("./controllers/messaging.php", formData)
      .then(function (response) {
        if (response.data.status === "error") {
          console.error("Error sending message:", response.data.message);
          showNotification(response.data.message, "error");
        } else {
          const { message, type } = response.data;
          appendMessageHTML(
            type === "image" ? message : message,
            type === "image"
          );
          showNotification("Message sent successfully", "success");
        }
      })
      .catch(function (error) {
        console.error("Error:", error);
        showNotification("Failed to send message. Please try again.", "error");
      });
  }

  function showNotification(message, type) {
    const notification = document.createElement("div");
    notification.className = `notification is-${
      type === "error" ? "danger" : "success"
    } is-light`;
    notification.style.position = "fixed";
    notification.style.top = "20px";
    notification.style.right = "20px";
    notification.style.zIndex = "1000";

    notification.innerHTML = `<button class="delete"></button> ${message}`;
    document.body.appendChild(notification);

    const deleteButton = notification.querySelector(".delete");
    deleteButton.addEventListener("click", function () {
      notification.remove();
    });

    setTimeout(() => {
      if (notification.parentNode) {
        notification.remove();
      }
    }, 5000);
  }

  sendButton.addEventListener("click", () => sendMessage());

  messageInput.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      sendMessage();
    }
  });

  imageButton.addEventListener("click", function () {
    imageInput.click();
  });

  imageInput.addEventListener("change", function () {
    if (imageInput.files.length > 0) {
      const file = imageInput.files[0];
      sendMessage(file);
    }
  });

  messageInput.focus();
});
