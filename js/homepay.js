function addBilling(event) {
    var d = $('select[name="dbil"]')["0"].value;
    $.get("/ajax/addBilling.php", { meter: this.id, billing: this.innerText, date: d });
}

function selectBil(event) {
    var d = $('select[name="dbil"]')["0"].value;
    var h = $('select[name="hbil"]')["0"].value;
    window.location = "/homepay/" + h + "-" + d;
}

$(document).on("change", "select", selectBil)
$(document).on("blur", "div[contenteditable]", addBilling);

let vb = new Vue({
    el: "#homepay",
    data: {
        jdbil: jdbil,
        dateb: dateb,
        bill: jdata,
        home: home,
        hId: hId,
        bilhead: ['Счетчик', 'Услуга', 'Было', 'Стало', 'Расход', 'Цена', 'Сумма']
    },
    watch: {
        dateb: function() {
            if (this.dateb !== +this.dateb) {
                this.dateb = +vb.dateb.replace(/-/g, '');
                if (this.jdbil.filter(function(e) { return e == vb.dateb }).length == 0) {
                    this.jdbil.push(this.dateb)
                }
                setTimeout(selectBil, 100);
            }
        }
    },
    mounted: function() {
        M.AutoInit()
    },
    methods: {
        calcTarif: function(nam) {
            return 5
        }
    }
})