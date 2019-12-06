<template>
<div class="row">
  <div class="col-md-6">
    <!-- Post Item -->
    <div class="card mt-4" v-for="(post, i) in posts" :key=i>
      <img v-if="post.post_images.length" class="card-img-top" :src="post.post_images[0].post_image_path" alt="">
      <div class="card-body">
        <h5 class="card-title">{{post.title}}</h5>
        <p class="card-text">{{ truncateText(post.body) }}</p>
        <button class="btn btn-success m-2" @click="viewPost(i)">View Post</button>
      </div>
    </div>


    <!-- Current Post -->

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
          <el-button type="primary" @click="postDialogVisible = false">Okay</el-button>
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
    }
  }

}
</script>