import { createStore } from 'vuex'

const state = {
    user: null,
    userpage: null,
    titleheader: null,
    addsastranotif: null,
    query: null,
    deletesastranotif: null,
    likecount: null
};

const store = createStore({
    state,
    getters: {
        user: (state) => {
            return state.user;
        },
        userpage: (state) => {
            return state.userpage
        },
        titleheader: (state) => {
            return state.titleheader
        },
        addsastranotif: (state) => {
            return state.addsastranotif
        },
        query: (state) => {
            return state.query
        },
        deletesastranotif: (state) => {
            return state.deletesastranotif
        },
        likecount: (state) => {
            return state.likecount
        },
        sastracount: (state) => {
            return state.sastracount
        }
    },
    actions: {
        getuser({commit}, user) {
            commit("user", user);
        },
        getuserpage({commit}, userpage) {
            commit("userpage", userpage)
        },
        gettitleheader({commit}, titleheader) {
            commit("titleheader", titleheader)
        },
        getaddsastranotif({commit}, addsastranotif) {
            commit("addsastranotif", addsastranotif)
        },
        getquery({commit}, query) {
            commit("query", query)
        },
        getdeletesastranotif({commit}, deletesastranotif) {
            commit('deletesastranotif', deletesastranotif)
        },
        getlikecount({commit}, likecount) {
            commit('likecount', likecount)
        },
        getsastracount({commit}, sastracount) {
            commit('sastracount', sastracount)
        }
    },
    mutations: {
        user(state, getuser) {
            state.user = getuser;
        },
        userpage(state, getuserpage) {
            state.userpage = getuserpage
        },
        titleheader(state, gettitleheader) {
            state.titleheader = gettitleheader
        },
        addsastranotif(state, getaddsastranotif) {
            state.addsastranotif = getaddsastranotif
        },
        query(state, getquery) {
            state.query = getquery
        },
        deletesastranotif(state, getdeletesastranotif) {
            state.deletesastranotif = getdeletesastranotif
        },
        likecount(state, getlikecount) {
            state.likecount = getlikecount
        },
        sastracount(state, getsastracount) {
            state.sastracount = getsastracount
        }
    }
});


export default store;
