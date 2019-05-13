import Axios from "axios";

export function login(credentials){
        return new Promise((res, rej)=>{
        Axios.post('/api/auth/login',credentials).then((response)=>{

            res(response.data)
        })
        .catch((err)=>{
            // console.log(err)
            rej(err)
        })
    })



}

export function getLocalUser(){
    const userStr = localStorage.getItem('user')

    if(!userStr){
        return null
    }

    return JSON.parse(userStr)
}
