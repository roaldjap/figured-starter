<template>
<div class="row">
  <div class="col-md-12">
    <!-- Post Item -->
    <div class="card mt-4" v-for="(post, i) in posts" :key=i>
      <img v-if="post.post_images.length" class="card-img-top" :src="post.post_images[0].post_image_path" alt="">
      <div class="card-body">
        <h5 class="card-title">{{post.title}}</h5>
        <p class="card-text">{{ truncateText(post.body) }}</p>
        <button class="btn btn-primary m-2" @click="viewPost(i)">View Post</button>
        <button class="btn btn-danger m-2" @click="deletePost(i)">Delete Post</button>
      </div>
    </div>


    <!-- Show Current Post to Modal -->
    <el-dialog v-if="currentPost" :visible.sync="postDialogVisible" width="40%">
      <span>

        <h3>{{ currentPost.title }}</h3>
        <div class="row">
        <div class="col-md-6" v-for="(img, i) in currentPost.post_images" :key=i>
          <img class="img-thumbnail" :src="img.post_image_path" alt="">
        </div>
        </div>
        <hr>
        <p>{{ currentPost.body }}</p>

        <span slot="footer" class="dialog-footer">
          <el-button type="primary" @click="postDialogVisible = false">Ok</el-button>
        </span>

      </span>
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
        return `${text.substr(0, 24)}...`
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
      alert(post._id);
      axios.delete(`post/${post._id}/delete_post`)
          .then((res)=>{
            alert(`${post._id} - was deleted`);
            this.$store.dispatch('getAllPosts');
          })
          .catch((err) => {
            console.log(err);
            alert('Something went wrong. please console.');
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