<template>
    <div class="container">
        <div class="row">
            <div v-for="album in albums" class="album col-4">
                <div v-for="image in album" class="img-container">
                    <img :src="'uploads/' + image.img_path"/>
                </div>
            </div>
        </div>
        <div class="row">
            <button @click="generateVariation" class="btn btn-primary p-1 m-1 generate-btn">Generate</button>
        </div>
    </div>
</template>
<script>
    export default {
        name: "Albums",
        mounted() {

            let _self = this;

            _self.getImages();

        },
        methods: {
            async getImages() {
                let _self = this;
                axios.get('api/image')
                    .then(response => {
                        _self.albums = response.data;
                        _self.albumsViewCount = Object.keys(_self.albums).length;
                        _self.albumsStart = 0;
                        _self.albumsEnd = Object.keys(_self.albums).length
                    })
                    .catch(err => {
                        console.error(err);
                    });
            },
            async generateVariation() {
                let _self = this;
                if (_self.variations.length === 0) {
                    axios.get('api/image/variations')
                        .then(response => {
                            console.log(response);
                            _self.variations = response.data;
                            _self.albums = _self.variations.slice(_self.albumsStart, _self.albumsEnd);
                            _self.albumsStart += _self.albumsViewCount;
                            _self.albumsEnd += _self.albumsViewCount;
                        })
                        .catch(err => {
                            console.error(err);
                        });
                } else {
                    _self.albums = _self.variations.slice(_self.albumsStart, _self.albumsEnd);
                    _self.albumsStart += _self.albumsViewCount;
                    _self.albumsEnd += _self.albumsViewCount;
                }

            }
        },
        data() {
            return {
                albums: {},
                albumsViewCount: 0,
                albumsStart: 0,
                albumsEnd: 0,
                variations: []
            }
        }
    }
</script>
<style>
    .album {
        position: relative;
        height: 400px;
        background-color: #e7f1ff;
        padding-top: 110px;
        margin: 100px auto;
        z-index: 100;
    }

    .img-container {
        position: absolute;
        right: 0;
        height: 250px;
        width: 250px;
        margin: 10px;
        z-index: 100;
        box-sizing: content-box;
    }

    .img-container img {
        position: absolute;
        bottom: 0;
        right: 0;
        height: 250px;
        width: 250px;
        z-index: 100;
        border: 1px black solid;
        padding: 2px;
        background-color: white;
    }

    .album .img-container:nth-child(1), .album .img-container:nth-child(1) img {
        z-index: 200;
    }

    .album .img-container:nth-child(2), .album .img-container:nth-child(2) img {
        transform: translate3d(-5%, -10%, 0);
        z-index: 199;
    }

    .album .img-container:nth-child(3), .album .img-container:nth-child(3) img {
        transform: translate3d(-10%, -15%, 0);
        z-index: 198;
    }

    .album .img-container:nth-child(4), .album .img-container:nth-child(4) img {
        transform: translate3d(-15%, -20%, 0);
        z-index: 197;
    }

    .generate-btn {
        width: 200px;
    }

</style>
