import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

const debug = process.env.NODE_ENV != 'production';

export default new Vuex.Store({

  state: {
    posts: [],
  },

  actions: {
    async getAllPosts({commit}){
      console.log(axios.get('post/get_all'));
      return commit('setPosts', await axios.get('post/get_all'));
    },
  },

  mutations: {
    setPosts(state, response){
      state.posts = response.data.data;
    },
  },

  strict: debug

});