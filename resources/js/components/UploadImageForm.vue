<template>
    <div class="upload-image-container row">
        <div class="upload-image-form">
            <h1>Upload Image</h1>
            <hr>
            <label for="album"> Array Index : </label>
            <input v-model="album" type="number" min="0" max="14" value="0" name="album" id="album"/>
            <label for="img-upload"> Upload </label>
            <input @change="selectImage" type="file" class="img-upload btn btn-primary p-2 m-1" name="img-upload"
                   id="img-upload"
                   accept="image/png,image/gif,image/jpeg"/>
            <button @click="addImage" class="btn btn-primary p-1 m-1">Add</button>
        </div>

    </div>
</template>
<script>
    export default {
        name: "UploadImageForm",
        methods: {
            selectImage(e) {

                let _self = this;

                let element = e.target;

                _self.img = element.files[0];

            },
            async addImage() {

                let _self = this;

                let postData = new FormData();

                postData.append("album", parseInt(_self.album) + 1); // add 1. Database autoincrement starts at 1

                postData.append("img", _self.img);

                axios.post('api/upload-image', postData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    console.log(response);
                }).catch(err => {
                    console.error(err);
                });
            }
        },
        data() {
            return {
                img: {},
                album: 0
            }
        }
    }
</script>
<style>
    .upload-image-form {
        background-color: #e7f1ff;
        width: 350px;
        height: 250px;
        margin: 100px auto;
        border: solid black 1px;
        padding: 20px;
    }
</style>
