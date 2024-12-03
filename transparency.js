// Simpan Data
const data = {
    1: {
        title: "Sarah Heart Surgery",
        detail: [
            "Hospital Fee",
            "Sarah Medicine",
            "Fruit & Food",
            "Transportation"
        ],
        fee: [
            79000000,
            5580000,
            73000,
            650000
        ]
    },
    2: {
        title: "Baby Naura Cancer",
        detail: [
            "Hospital Fee",
            "Medicine",
            "Fruit & Food",
            "Daily Expense"
        ],
        fee: [
            57000000,
            3500000,
            98000,
            102000
        ]
    },
    3: {
        title: "Rawa Bengkok Village Fire",
        detail: [
            "Food & Beverage",
            "Clothes",
            "Camp",
            "Water"
        ],
        fee: [
            21000000,
            5505000,
            13000000,
            2095000
        ]
    },
    4: {
        title: "Mount Moana Eruption",
        detail: [
            "Foods & Beverages",
            "Clothes",
            "Camp",
            "Water"
        ],
        fee: [
            77000000,
            3200000,
            40000000,
            3200000
        ]
    },
    5: {
        title: "Cibauk Earthquake",
        detail: [
            "Foods & Beverages",
            "Clothes",
            "Bed & Blanket",
            "Camp",
            "Water"
        ],
        fee: [
            68679000,
            1750000,
            570000,
            21500600,
            3200400
        ]
    },
    6: {
        title: "Help Alfred",
        detail: [
            "Foods & Beverages",
            "Clothes",
            "Daily Expenses"
        ],
        fee: [
            9100000,
            3200000,
            400000,
        ]
    },
    7: {
        title: "Ben & Anna, The Struggle Twin",
        detail: [
            "Foods & Beverages",
            "Clothes",
            "Daily Expenses"
        ],
        fee: [
            70000000,
            4000000,
            21900000
        ]
    },
    8: {
        title: "Cikurung Flood",
        detail: [
            "Foods & Beverages",
            "Clothes",
            "Bed & Blanket",
            "Camp",
            "Water"
        ],
        fee: [
            187000000,
            3200000,
            55100000,
            21900000,
            3200000
        ]
    },
};

const popup = document.getElementById('popup');
const popupTitle = document.getElementById('title');
const popupData = document.getElementById('data');
const popupTotal = document.getElementById('count');
const exit = document.getElementById('exit');
const Tot = document.getElementById('sumTot');

// jumlah tiap donasi
const Sum = [];
for (let i = 1; i <= Object.keys(data).length; i++) {
    Sum[i-1] = data[i].fee.reduce((sum, current) => sum + current, 0);
}

// jumlah total seluruh donasi
const sumTot = Sum.reduce((sum, current) => sum + current, 0);
const sumTotX = sumTot.toLocaleString('id-ID');
Tot.textContent = "-" + sumTotX;

document.querySelectorAll('.card').forEach(div => {
    div.addEventListener('click', function () {
        const dataID = this.getAttribute('data-id');
        const info = data[dataID];

        if (info) {
            popupTitle.textContent = info.title;
            
            //function
            const container = document.getElementById("nota");
            container.innerHTML = "";
            info.detail.forEach((detailItem, index) => {
                const grid = document.createElement("div");
                grid.className = "grid";

                const detailSpan = document.createElement("span");
                detailSpan.textContent = detailItem;
                
                const detailFee = document.createElement("span");
                detailFee.textContent = info.fee[index].toLocaleString('id-ID');

                grid.appendChild(detailSpan);
                grid.appendChild(detailFee);

                container.appendChild(grid);
            });

            const total = info.fee.reduce((sum, current) => sum + Number(current), 0);
            popupTotal.textContent = "Rp " + total.toLocaleString('id-ID');

            popup.style.display = 'flex';
            exit;
        }else{
            console.error("404")
        }
    });
});


exit.addEventListener('click', function() {
    popup.style.display = 'none';
});

window.addEventListener('click', function(event) {
    if (event.target === popup) {
        popup.style.display = 'none';
    }
});
