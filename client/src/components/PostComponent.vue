 <template>
   <div class="container">
      <h1>Latest Posts</h1>
      <hr>
      <p class="error" v-if="error">{{ error }}</p>
      <div class="post-container">
        <div class="post"
          v-for="(post,index) in posts"
          v-bind:item="post"
          v-bind:index="index"
          v-bind:key="post.id"
        >
        <p>{{ post.title }}</p>
        </div>
      </div>
   </div>
</template>

<script>
import PostService from '../PostService';
export default {
  name: 'PostComponent',
  data(){
      return {
          posts: [],
          error: '',
          text: ''
      }
  },
  async created(){
    try{
      this.posts = await PostService.getPosts();  
    }catch(err){
        this.error = err.message;
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
