<template>
    <div class="container-fluid pt-5">
        <div class="row pt-3">
            <div class="col-lg-5 col-sm-12 pr-5 mt-5 mb-5" id="leftside">
                <div>
                    <h1>Landing Page title</h1>
                    <br><br>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi quasi praesentium assumenda ullam officia repellat quis dignissimos! Quae sequi, commodi rerum unde voluptate fuga nam tempore at porro nesciunt iusto.
                    </p>
                </div>
                
                <button class="btn btn-lg mt-5 mb-5" id="myButton">See more of our Best Seller</button>
            </div>

            <div class="col-lg-7 col-sm-12 mt-3" id="rightside">
                
            </div>
        </div>
        
    </div>
</template>

<style scoped>

#myButton {
    background: #800000;
    color: #ffffff;
    margin-left: 10%;
    font-weight: 700;
    font-size: 2em;
    min-width: 80%;
    border-radius: 0;
    border-bottom-left-radius: 50px 70px;
}

#rightside {
    min-height: 50%;
    background: url('../img/mod-bg.jpg');
    background-size: cover;
    background-position: center;
}

h1 {
    color: #ffffff;
    font-size: 2.5rem;
    font-weight: 700;
    font-family: sans-serif;
    text-transform: uppercase;
    letter-spacing: 5px;
}

p {
    color: #c1c1c1;
    font-size: 1.2em;
    letter-spacing: 3px;
}

</style>