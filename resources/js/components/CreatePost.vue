<template>
  <div class="card mt-4">
    <div class="card-header">Create a Post</div>
    <div class="card-body">
      <div v-if=status_msg :class="{'alert-success': status, 'alert-danger': !status }" class="alert" role="alert">
          {{ status_msg }}
      </div>
      <form>
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" v-model="title" class="form-control" id="title" placeholder="Post Title" required>
        </div>
        <div class="form-group">
          <label for="body">Content</label>
          <textarea type="text" v-model="body" class="form-control" id="body" placeholder="Content here.." required></textarea>
        </div>
        <div class="form-group">
          <el-upload action="/" list-type="picture-card"
            :on-preview="handlePictureCardPreview"
            :on-change="updateImageList"
            :auto-upload="false"
          >
          <i class="el-icon-plus"></i>
          </el-upload>
          <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt="">
          </el-dialog>
        </div>
      </form>
    </div>
    <div class="card-footer">
        <button type="button" @click="createPost" class="btn btn-success">
          {{ isCreatingPost ? 'Publishing your Post...' : 'Create Post'}}
        </button>
    </div>
  </div>
</template>

<script>
import {mapActions} from 'vuex';
import axios from 'axios';

export default {

  name: 'create-post',
  props: ['posts'],
  data(){
    return{
      dialogImageUrl: '',
      dialogVisible: false,
      imageList: [],
      status_msg: '',
      status: '',
      isCreatingPost: false,
      title: '',
      body: ''
    };
  },

  computed:{
    ...mapActions(['posts'])
  },

  methods: {
    updateImageList(file){
      this.imageList.push(file.raw);
    },

    handlePictureCardPreview(file){
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },

    showNotification(message){
      this.status_msg = message;
      setTimeout(() => {
        this.status_msg = '';
      }, 3000);
    },

    validateForm(){
      console.log(!this.title);
      if(!this.title){
        this.status = false;
        this.showNotification("Come on, Put some TITLE on your post.");
        return false
      }
      if(!this.body){
        this.status = false;
        this.showNotification("CONTENT. One of the most important thing on a blog post.");
        return false
      }

    },

    createPost(e){
      e.preventDefault();
      this.validateForm();

      if(this.status === false){
        this.isCreatingPost = false;
      } else{
        this.isCreatingPost = true;
        let formData = new FormData();

        formData.append('title', this.title);
        formData.append('body', this.body);

        $.each(this.imageList, function(key, image){
          // Put images in an array
          formData.append(`images[${key}]`, image)
        });

        axios.post('/post/create_post', formData, {headers: {'Content-Type': 'multipart/form-data'}})
          .then((res)=>{
            // Reset form
            this.title = this.body = '';
            this.status = true;
            this.showNotification('Post Successfully created');
            this.isCreatingPost = false;
            this.$store.dispatch('getAllPosts');
        });

      }

      
    }
    
  }

}


</script>