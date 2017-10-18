export default {
    SET_DATA(state, data){
        state.data = data;
    },
    SET_TRANS(state, trans){
        state.trans = trans;
    },
    UPDATE_BREADCRUMBS(state, breadcrumbs){
        state.data.breadcrumbs = breadcrumbs;
    },
    UPDATE_RESULTS_COUNT(state, count){
        state.data.resultsCount = count;
    },
    UPDATE_ITEMS(state, items){
        state.data.items = items;
    },
    TOGGLE_LOADING(state, a){
        state.loading = a ? a : !state.loading;
    },
    UPDATE_HEADER(state, header){
        state.data.header = header;
    },
    UPDATE_PARAMETERS(state, parameters){
        state.data.parameters = parameters;
    },
    UPDATE_PAGER(state, pager){
        state.data.pager = pager;
    },
    UPDATE_PAGESIZE(state, size){
        state.data.pageSize = size;
    }
}