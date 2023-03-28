// get data parsed from blade php
try{
    if(parsing_var){
        // console.log(stocks);
        console.log(parsing_var.message);
    }
}catch(err) {
    console.log(err);
}

// tensorflow js does not support preprocessing Normalization layer as of the time writing
// try{
//     model =  await tf.loadLayersModel('roff_model/tfjs_roff/model.json')
//     console.log('complete')
// }catch(err) {
//     console.log(err);
// }