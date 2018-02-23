$_POST['fieldname']

<button>Click me</button>

<p id="demo"></p>

<script>
    $(document).ready(function () {
        $("button").click(function () {
            $.post("demo_test_post.asp",
                {
                    name: "Donald Duck",
                    city: "Duckburg"
                },
                function (data, status) {
                    alert("Data: " + data + "\nStatus: " + status);
                });
        });
    });
    <
    script >;