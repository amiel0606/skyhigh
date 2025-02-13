<?php
include_once './includes/header.php';
?>
<style>
    .content {
        width: 1900px;
        height: 100vh;
    }

    .sidebar {
        background-color: #6A8DAF;
        width: 250px;
        height: 450px;
        padding: 20px;
    }

    .menu-label {
        font-weight: bold;
    }

    .menu-list a {
        color: white;
    }

    .menu-list a:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .columns {
        margin-top: 70px;
    }

    .content {
        margin: 0;
    }

    .list-item a {
        background-color: transparent !important;
    }

    .list-item a:hover {
        background-color: #212429 !important;
    }

    .list-item {
        list-style-type: none;
    }

    .product-container {
        max-height: 700;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 20px;
        border-radius: 10px;
        white-space: normal;
        display: flex;
        justify-content: center;
        margin-top: -100px;
    }

    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        max-width: 900px;
    }

    .product-item {
        background-color: white;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
        width: 250px;
    }

    .product-item:hover {
        transform: scale(1.05);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .product-image {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }
</style>

<div class="columns is-centered">
    <!-- Sidebar -->
    <div class="column is-2 sidebar has-text-white">
        <p class="title is-5 has-text-white">Category</p>
        <aside class="menu">
            <p class="menu-label has-text-white">
                <a onclick="toggleDropdown('muffler-dropdown')" class="has-text-white"> Muffler ▼
                </a>
            </p>
            <ul id="muffler-dropdown" class="menu-list is-hidden">
                <li class="list-item"><a href="#">Option 1</a></li>
                <li class="list-item"><a href="#">Option 2</a></li>
            </ul>
            <p class="menu-label has-text-white dropdown-trigger">
                <a onclick="toggleDropdown('mags-dropdown')" class="has-text-white">MAGS ▼</a>
            </p>
            <ul id="mags-dropdown" class="menu-list is-hidden">
                <li class="list-item"><a href="#">Option 1</a></li>
                <li class="list-item"><a href="#">Option 2</a></li>
            </ul>
            <p class="menu-label has-text-white">Tire</p>
            <p class="menu-label has-text-white">Shock</p>
            <p class="menu-label has-text-white">Fairings</p>
        </aside>
    </div>

    <!-- Main Content -->
    <div class="column is-10">
        <div class="box has-background-primary product-container">
            <div class="columns is-multiline is-mobile">

                <div class="column is-one-third">
                    <div class="box product-item">
                        <img src="../img/123sd-removebg-preview 1.png" alt="Product" class="product-image">
                        <p class="has-text-weight-bold">Product 1</p>
                    </div>
                </div>

                <div class="column is-one-third">
                    <div class="box product-item">
                        <img src="../img/123sd-removebg-preview 1.png" alt="Product" class="product-image">
                        <p class="has-text-weight-bold">Product 2</p>
                    </div>
                </div>

                <div class="column is-one-third">
                    <div class="box product-item">
                        <img src="../img/123sd-removebg-preview 1.png" alt="Product" class="product-image">
                        <p class="has-text-weight-bold">Product 3</p>
                    </div>
                </div>

                <div class="column is-one-third">
                    <div class="box product-item">
                        <img src="../img/123sd-removebg-preview 1.png" alt="Product" class="product-image">
                        <p class="has-text-weight-bold">Product 4</p>
                    </div>
                </div>

                <div class="column is-one-third">
                    <div class="box product-item">
                        <img src="../img/123sd-removebg-preview 1.png" alt="Product" class="product-image">
                        <p class="has-text-weight-bold">Product 5</p>
                    </div>
                </div>

                <div class="column is-one-third">
                    <div class="box product-item">
                        <img src="../img/123sd-removebg-preview 1.png" alt="Product" class="product-image">
                        <p class="has-text-weight-bold">Product 6</p>
                    </div>
                </div>

                <div class="column is-one-third">
                    <div class="box product-item">
                        <img src="../img/123sd-removebg-preview 1.png" alt="Product" class="product-image">
                        <p class="has-text-weight-bold">Product 6</p>
                    </div>
                </div>

                <div class="column is-one-third">
                    <div class="box product-item">
                        <img src="../img/123sd-removebg-preview 1.png" alt="Product" class="product-image">
                        <p class="has-text-weight-bold">Product 6</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<script>
    function toggleDropdown(id) {
        let dropdown = document.getElementById(id);
        dropdown.classList.toggle("is-hidden");
    }
</script>
<?php
include_once './includes/footer.php';
?>