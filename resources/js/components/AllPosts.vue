<template>
<div class="row">
  <div class="col-md-12">
    <!-- Post Item -->
    <div class="card mt-4" v-for="(post, i) in posts" :key=i>
      <img v-if="post.post_images.length" class="card-img-top" :src="post.post_images[0].post_image_path" alt="">
      <div class="card-body">
        <h5 class="card-title">{{post.title}}</h5>
        <p class="card-text">{{ truncateText(post.body) }}</p>
        <button class="btn btn-primary mr-2" @click="viewPost(i)">View Post</button>
        <button class="btn btn-success mr-2" @click="editPost(i)">Edit Post</button>
        <button class="btn btn-danger mr-2" @click="deletePost(i)">Delete Post</button>
      </div>
    </div>


    <!-- Show Post to Modal -->
    <el-dialog v-if="currentPost" :visible.sync="postDialogVisible">
      <span>

        <h3>{{ currentPost.title }}</h3>
        <div class="row">
        <div class="col-md-6" v-for="(img, i) in currentPost.post_images" :key=i>
          <img class="img-thumbnail" :src="img.post_image_path" alt="">
        </div>
        </div>
        <hr>
        <p>{{ currentPost.body }}</p>

        <el-button type="primary" @click="postDialogVisible = false">Ok</el-button>

      </span>
    </el-dialog>

     <!-- Show form to Modal -->
    <el-dialog v-if="editCurrentPost" :visible.sync="editPostDialogVisible" width="40%">
      <!-- Update text only form -->
      <form>
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" v-model="editTitle" class="form-control" id="title" placeholder="Post Title" required>
        </div>
        <div class="form-group">
          <label for="body">Content</label>
          <textarea type="text" v-model="editBody" class="form-control" id="body" placeholder="Content here.." required></textarea>
        </div>
      </form>
      
      <!-- Button -->
      <button type="button" @click="updatePost" class="btn btn-success">
        {{ isUpdatingPost ? 'Updating your Post...' : 'Update Post'}}
      </button>
    </el-dialog>            

  </div>
</div>
</template>

<script>
import {mapState} from 'vuex';

export default {
  name: 'all-posts',
  data(){
    return{
      postDialogVisible: false,
      currentPost: '',
      editPostDialogVisible: false,
      editCurrentPost: '',
      editTitle: '',
      editBody: '',
      isUpdatingPost: false
    }
  },
  computed:{
    ...mapState(['posts'])
  },
  beforeMount(){
    this.$store.dispatch('getAllPosts');
  },
  methods:{
    // truncate text
    truncateText(text){
      if(text.length > 24){
        return `${text.substr(0, 300)}...`
      }
      return text;
    },
    // view post
    viewPost(postIndex){
      const post = this.posts[postIndex];
      console.log(post);
      this.currentPost = post;
      this.postDialogVisible = true;
    },

    // delete post
    deletePost(postIndex){
      const post = this.posts[postIndex];

      // select id and delete request to backend
      axios.delete(`post/${post._id}/delete_post`)
          .then((res)=>{
            alert(`${post._id} - was deleted`);
            this.$store.dispatch('getAllPosts');
          })
          .catch((err) => {
            console.log(err);
            alert('Delete Post - Feature: Something went wrong. please console.');
          });
    },

    editPost(postIndex){
      const post = this.posts[postIndex];
      
      this.editCurrentPost = post;

      // select id and delete request to backend
      console.log(post);
      this.editTitle = post.title;
      this.editBody = post.body;
      this.editCurrentPost = post;
      this.editPostDialogVisible = true;
    },

    updatePost(){
      const post = this.editCurrentPost;
      let editFormData = {
        'title': this.editTitle,
        'body': this.editBody
      };

      this.isUpdatingPost = true;

      axios.put(`post/${post._id}/edit_post`, editFormData)
        .then((res)=>{
            alert("Successful - Post Updated");
            this.$store.dispatch('getAllPosts');
            this.isUpdatingPost = false;
        })
        .catch((err) => {
          console.log(err);
          alert('Update Post - Feature: Something went wrong. please console.');
        });
    }
  }

}
</script>

<style>
  .card-columns {
      column-count: 1;
  }
  .card-img-top {
    width: 100%;
    height: 15vw;
    object-fit: cover;
  }
</style>