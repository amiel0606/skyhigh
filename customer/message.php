<?php
include_once './includes/header.php';
?>
<section class="section">
    <div class="container">
        <div class="columns is-gapless is-fullheight">
            <div class="column is-one-fifth box has-background-dark user-list">
                <h3 class="title is-6 has-text-white m-3">Users</h3>
                <div class="menu">
                    <ul class="menu-list">
                        <li class="menu-item mb-2"><a class="has-text-white">User 1</a></li>
                        <li class="menu-item mb-2"><a class="has-text-white">User 2</a></li>
                        <li class="menu-item mb-2"><a class="has-text-white">User 3</a></li>
                        <li class="menu-item mb-2"><a class="has-text-white">User 4</a></li>
                        <li class="menu-item mb-2"><a class="has-text-white">User 5</a></li>
                        <li class="menu-item mb-2"><a class="has-text-white">User 6</a></li>
                    </ul>
                </div>
            </div>

            <div class="column is-four-fifths box has-background-light chat-container">
                <h3 class="title is-5 has-text-black m-3">Client Name</h3>
                <div class="chat-messages">
                    <p class="contact-message"><strong>User 1:</strong> Hello!</p>
                    <p class="my-message"><strong>You:</strong> Hi, how are you?</p>
                    <p class="contact-message"><strong>User 2:</strong> I’m good, what about you?</p>
                    <p class="my-message"><strong>You:</strong> Just chilling.</p>
                    <p class="contact-message"><strong>User 3:</strong> That’s cool!</p>
                </div>
                <div class="field has-addons mt-4">
                    <div class="control is-expanded">
                        <input class="input" type="text" placeholder="Type a message...">
                    </div>
                    <div class="control">
                        <button class="button is-primary">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .is-fullheight {
        height: 90vh;
    }

    .user-list {
        height: 600px;
        overflow-y: auto;
        padding: 10px;
        width: 300px !important;
    }

    .chat-container {
        height: 600px;
        display: flex;
        flex-direction: column;
        padding: 10px;
        width: 1200px !important;
    }

    .chat-messages {
        flex-grow: 1;
        overflow-y: auto;
        background: white;
        padding: 10px;
        border-radius: 5px;
        height: 600px;
    }

    .contact-message {
        background-color: #f1f1f1;
        padding: 10px;
        border-radius: 20px;
        margin: 5px 0;
        max-width: 80%;
        align-self: flex-start;
    }

    .my-message {
        background-color: #007bff;
        color: white;
        padding: 10px;
        border-radius: 20px;
        margin: 5px 0;
        max-width: 80%;
        align-self: flex-end;
    }

    .container {
        max-width: 1300px;
        margin-left: -550px;
        margin-top: -50px;
    }
</style>

<?php
include_once './includes/footer.php';
?>
