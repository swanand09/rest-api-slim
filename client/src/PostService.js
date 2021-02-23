import axios from 'axios';

const url = "https://pressbook.test.api/list-per-page/?per_page=10";

class PostService{

    //Get Posts
    static getPosts(){ 
         
        return new Promise(async (resolve, reject)=>{
            
            try{

                const res = await axios.get(url);
                const data = res.data;
                resolve(
                    data.map(post=>({
                        ...post,
                       // createAt: new Date(post.createAt)

                    }))
                )

            }catch(err){
                
                reject(err);
            }
        })
    }

    //Create Posts
    static insertPost(text){
        return axios.post(url,{
            text
        });
    }

    //Delete Posts
    static deletePost(id){

        return axios.delete(`${url}${id}`);
    }

}   

export default PostService;