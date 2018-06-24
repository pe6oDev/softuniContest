<!--
AdminTable

Vue компонент за всички таблици в admin панела
грижи се за:
    - асинхронното зареждане на записи
    - търсенето на записи по избрано(и) поле(та)
    - сортирането по избрано поле
-->
<template>

    <div class="ui center aligned  grid">
        <!--колко от колко -->
        <div v-if="data && showTotalNum" class="ui row">
            <div class="ui sixteen wide right aligned column">
                {{data.length}}/{{totalNum}}
            </div>

        </div>

        <div class="ui row">
            <div class="ui seventeen  wide column">

                <!--Таблицата-->
                <table class="ui  fluid celled table green">
                    <thead>

                    <tr>
                        <th v-for="(header, index) in tableHeaders" class="center aligned header"
                            v-bind:style="{ width: rowWidth[index]+'%' }"> <!--ако има задени размери за колоните се задават тук (в проценти)-->
                            <!--името на колоната-->
                            {{header}}
                            <!--Ако полето не е от списъка с изклютено сортиране се добавя sort бутон-->
                            <i v-if="noSort.indexOf(index) == -1" v-on:click="sort(index)"
                               class="sort ui icon">
                            </i>
                            <br/>
                            <br/>
                            <!--Ако полето не е от списъка с изклютено търсене (и няма checkbox търсене)
                            се добавя input поле за търсене -->
                            <span v-if="noSearch.indexOf(index) == -1 && checkBoxSearch.indexOf(index) == -1"
                                  class="ui  search">
                                <span class="ui input">
                                     <input v-model="searchQueries[index]" class="prompt" :placeholder="searchPrompt"
                                            type="text" style="width: 100%;"/>
                                </span>
                            </span>
                            <!--Ако полето Е от списъка с checkbox (да/не) търсене се добавят checkbox бутони  -->
                            <span v-if="checkBoxSearch.indexOf(index) != -1">
                                <!--Бутон за търсене за стойност bool(true) -->
                                <div v-show="!checkBoxSearchQueries[index]['no']" class="ui  checkbox">
                                         <input type="checkbox" name="yes" id="yes"
                                                v-model="checkBoxSearchQueries[index]['yes']"/>
                                      <label><i class="icon green check"></i></label>
                                    </div>
                                <!--Бутон за търсене за стойност bool(false) -->
                                <div v-show="!checkBoxSearchQueries[index]['yes']" class="ui  checkbox">
                                     <input type="checkbox" name="no" id="no"
                                            v-model="checkBoxSearchQueries[index]['no']"/>
                                      <label><i class="icon red delete"></i></label>
                                    </div>
                            </span>

                        </th>
                    </tr>
                    </thead>


                    <tbody>
                    <tr v-for="user in data">
                        <td class="center aligned">{{user["email"]}}</td>
                        <td class="center aligned">{{user['created_at']}}</td>
                        <td class="center aligned">
                            <!--Бутон за смяна на типа-->
                            <div class="ui dropdown">
                                <div class="default text" style="color: #000">
                                    <span v-if="user['type']=='customer'">клиент</span>
                                    <span v-if="user['type']=='partner'">партньор</span>
                                    <span v-if="user['type']=='employee'">служител</span>
                                    <span v-if="user['type']=='admin'">администратор</span>

                                </div>
                                <div class="menu">
                                    <div class="item" v-on:click='changeType(user["id"],"customer")'>клиент</div>
                                    <div class="item" v-on:click='changeType(user["id"],"partner")'>партньор</div>
                                    <div class="item" v-on:click='changeType(user["id"],"employee")'>служител</div>
                                    <div class="item" v-on:click='changeType(user["id"],"admin")'>администратор</div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    </tbody>


                    <!--Footer-а на таблицата -->
                    <tfoot>
                    <!--"Зареди още" бутон-->
                    <tr v-if="loadMoreEnabled && !noDataWarn &&  !loadingErr ">
                        <th class="ui center aligned " :colspan="tableHeaders.length">
                            <div v-on:click="loadMore" class="ui fluid   button">
                                {{loadMoreLabel}}
                            </div>
                        </th>
                    </tr>
                    <!--Съобщение за грешка (най-често при 500 от сървъра)-->
                    <tr v-if="loadingErr ">
                        <th class="ui center aligned " :colspan="tableHeaders.length">
                            <div class="ui error message">Error</div>
                        </th>
                    </tr>
                    <!--"Не бе открито нищо" съобщение-->
                    <tr v-if="!loadingErr && noDataWarn">
                        <th class="ui center aligned " :colspan="tableHeaders.length">
                            <div class="ui warning message">{{nothingFoundMess}}</div>
                        </th>
                    </tr>
                    </tfoot>
                </table>

            </div>

        </div>
    </div>

</template>

<script>
import axios from 'axios'
export default {
    props: {

        //адреса за сменяне на права (тип потребител)
        changeTypeUrl: {
            type: String,
        },

        /**
         * getN - по колко записа да взима от базата
         */
        getN: {
            type: Number,
            default: 20,
            required: false,
            validator: function (value) {
                return value >= 0
            },
        },
        /**
         * loadUrl - адреса, към който се правят всички заявки
         */
        loadUrl: {
            type: String,
            required: true,
        },
        /**
         * nothingFoundMess - какво да се изписва
         * при връщане на празен[]
         * най чест  = "не бе открито нищо" || "Nothing found"
         */
        nothingFoundMess: {
            type: String,
            default: 'Nothing found!'
        },
        /**
         * searchPrompt - hint-a на полетата за търсене
         * най-често = 'търси' || 'search'
         */
        searchPrompt: {
            type: String,
            default: 'search'
        },
        /**
         *  headerName - заглавието на страницата
         *  (изписва се над таблицата)
         */
        headerName: {
            required: true,
            type: String,
        },
        /**
         * loadMoreLabel - текста на бутона за "зареди още"
         * най често = "load more" || "зарадеи още"
         */
        loadMoreLabel: {
            type: String,
            required: true,
        },
        /**
         * tableHeaders - заглавията на колоните
         */
        tableHeaders: {
            type: Array,
            required: true,
        },
        /**
         * type - вижа на страницата
         * (използва за избиране на правилното таблично тяло)
         */
        type: {
            type: String,
            required: true,
            validator: function (value) {
                return ['days', 'users', 'visitLog', 'userSettings'].indexOf(value) != -1
            },
        },
        /**
         * keys - ключоете на полетата както са в базата
         * (използва се в случай че данните, които идват от сървъра са разбъркани спрямо tableHeaders)
         */
        keys: {
            type: Array,
            required: false,
        },
        /**
         * noSearch - index-ите на полета, по които да не се търси
         */
        noSearch: {
            type: Array,
            required: false,
            default: function () {
                return []
            }
        },
        /**
         * noSort - index-ите на полета, по които да не се сортира
         */
        noSort: {
            type: Array,
            required: false,
            default: function () {
                return []
            }
        },
        /**
         * checkBoxSearch - index-ите на полета, по които да се прави да/не търсене
         */
        checkBoxSearch: {
            type: Array,
            required: false,
            default: function () {
                return []
            }
        },
        /**
         * rowWidth - широчините на колоните (в % )
         * пример [20,20,20,40] - така първите 3 колони
         * ще заемат по 20% от наличното пространство
         */
        rowWidth: {
            type: Array,
            default: function () {
                return []
            },
            required: false
        },
        /**
         * showTotalNum
         * дали да покаже колко/колко
         */
        showTotalNum: {
            type: Boolean,
            default: function () {
                return true
            },
            required: true
        }
    },
    data(){
        //прави  checkBoxSearchQueries във масив с дължина = this.tableHeaders.length
        // във формат [{'yes':null,'no':null}, {'yes':null,'no':null} ...]
        var checkBoxSearchQueries = {};
        for (var i = 0; i <= this.tableHeaders.length; i++) {
            if (this.checkBoxSearch.indexOf(i) != -1)
                checkBoxSearchQueries[i] = {
                    'no': null,
                    'yes': null,
                };
        }
        return {
            'loadingErr': null, //дали има грешка при зареждането на данните
            'noDataWarn': null, //дали сървъра е върнал празен []
            'data': null, // данните за таблицата
            'skip': 0, //колко записа вече са заредни
            'loadMoreEnabled': true, // дали има възможност за зареждане на още
            'sortDirection': -1, // посоката на сортиране ( -1 = reverse)
            'searchQueries': {}, // заявките за търсене ( във вида  {$dataBaseField:$search } {'email':'test@gma'})
            'checkBoxSearchQueries': checkBoxSearchQueries,// заявките за да/не търсене ( във вида  {$dataBaseField:bool } {'email_notifications':false})
            'totalNum': 0, //броя на записите в базата (които отговярят на заявките за търсене)
        }
    },
    mounted() {
        //първоначално зареждане на даниите
        this.loadRequest();
    },
    methods: {


        /*
         сменя типа на потребител
         */
        changeType(userId, type){
           axios.post(this.changeTypeUrl,{
               userId:userId,
               type:type,
           }).then(()=>{
               console.log('done');
           })
        },

        /**
         * loadMore
         *
         * зарежда още данни
         *
         */
        loadMore(){
            this.loadRequest(this.skip);
        },
        /**
         * sort
         *
         * сортира по избрано поле
         * @param sortable{int} = index-a на полето
         *
         */
        sort(sortable){
            this.sortDirection *= -1;
            this.data = _.sortBy(this.data, [(o) => {
                return o[this.getKey(sortable)];
            }])
            ;
            if (this.sortDirection < 0) {
                this.data = _.reverse(this.data);
            }
        },

        /**
         * getKey
         *
         * Връща index-a, както е в масива с данните
         * пример index = 1 - връща day
         *
         * @param index {int}  елемент от this.headerName
         * @returns {string}
         */
        getKey(index){
            var rowKey = '';
            if (this.keys === undefined) {
                rowKey = Object.keys(this.data[0])[index];
            } else {
                rowKey = this.keys[index];
            }
            return rowKey
        },
        /**
         * loadRequest
         *
         * Прави заявка към сървъра (променя this.data)
         *
         * @param skip {int} колко записа да пропусне (използва се при loadMore)
         */
        loadRequest(skip = 0){
            //прави копия на this.realSearchQuery || this.realCheckBoxSearchQueries (защото иначе се trigger-ват watcher-ите им и взаимно се промненят)
            var textQueries = this.realSearchQuery;
            var checkBoxQueries = this.realCheckBoxSearchQueries;
            var search = {};
            _.forEach(textQueries, (e, i) => {
                search[i] = e;
            })
            ;
            _.forEach(checkBoxQueries, (e, i) => {
                search[i] = e;
            })
            ;

            axios.post(this.loadUrl, {
                'skip': skip,
                'take': this.getN,
                'search': search,

            }).then(d => {
                //ако НЕ е направена "зареди още" заявка
                if (skip == 0
                ) {
                    this.skip = this.getN;
                    this.loadMoreEnabled = true;
                    console.log(d.data.stats);
                    this.data = d.data.stats.data;
                    this.totalNum = d.data.stats.count;
                }
                //ако Е направена "зареди още" заявка
                else {
                    if (d.data.stats.data.length) {
                        this.skip = Number(this.skip) + Number(this.getN);
                        this.data = _.union(this.data, d.data.stats.data);
                    } else {
                        this.loadMoreEnabled = false;
                    }
                }
            }).catch(() => {
                this.loadingErr = true
            })
        },
        makeSearchQuery(arr){
            var q = _.mapKeys(arr, (value, key) => {
                    return this.getKey(key);
                })
                ;
            return _.omitBy(q, e => {
                return !Boolean(e) && e !== false;
            })
                ;
        }
    },
    watch: {
        realSearchQuery: _.debounce(
            function () {
                this.loadRequest()
            },
            //Броя милесекунди преди потребителя да спре да пише
            200
        ),
        checkBoxSearchQueries(){

        },
        realCheckBoxSearchQueries() {
            this.loadRequest()
        },
        data(){
            $('.ui.dropdown')
                .dropdown()
            ;
            if (!this.data.length) {
                this.noDataWarn = true;
            } else {
                this.noDataWarn = false;
            }

            if (this.data.length < Number(this.skip)) {
                this.loadMoreEnabled = false;
            }
        }
    },
    computed: {
        realSearchQuery(){
            return this.makeSearchQuery(this.searchQueries);
        },
        realCheckBoxSearchQueries(){
            var queries = {};
            _.forEach(this.checkBoxSearchQueries, function (e, i) {
                if (e['yes']) {
                    queries[i] = true;
                } else if (e['no']) {
                    queries[i] = false;
                }
            });
            return this.makeSearchQuery(queries);
        }
    },
}
</script>