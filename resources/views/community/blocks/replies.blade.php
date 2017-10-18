<script>
    var trans = {!! json_encode($labels) !!},
        json = {!! $results !!};

        console.log(json);
</script>

<div id="vue-app">
    <router-view></router-view>
</div>