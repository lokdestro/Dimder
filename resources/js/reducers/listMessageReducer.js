import {SET_LIST_MESSAGE, ADD_MESSAGE} from '../actions/constants.js';

export default function listMessageReducer(state = [], action) {
    switch (action.type) {
        case SET_LIST_MESSAGE:
            return setListMessage(state, action.payload);
        case ADD_MESSAGE:
            return addMessage(state, action.payload);
        default:
            return state;
    }
}
function setListMessage (state, payload){
    let message = (payload === null)
                    ? []
                    : payload
    return message
}

function addMessage (state, payload){
    if (!payload){
        return state;
    }
    return [...state, payload]
}

