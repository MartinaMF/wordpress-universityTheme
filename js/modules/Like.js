
import $ from 'jquery';
class Like {
    constructor(){
        this.events();
    }
    events(){

    }
    createLike($data){
        $professsor = sanitize_text_field($data['professorId']);
        $.ajax({
        url: mywebsiteData.root_url  + '/wp-json/mywebsite/v1/manageLike',
        type: 'POST',
        data:{'professorId':$professsor},
        succces: (response)=>{
            console.log(response)
        },
        error:(response)=>{
            console.log(reponse);
        }
        });
        }
    deletelike(){
        $.ajax({
            url : mywebsiteData.root_url  + '/wp-json/mywebsite/v1/manageLike',
            type: 'DELETE',
            success: ()=>{
                console.log(response);
            },
            error : (response)=>{
                console.log(response);
            }
        });
    }
}
