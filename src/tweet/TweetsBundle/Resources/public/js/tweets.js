/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $('#add_tweet').click(function () {
 $.ajax({
        type: "Post",
        url: Routing.generate('add_tweets'),
        success: function (data) {
            console.log(data);
            
        }

    });
});
