const curEl_one = document.getElementById("currency-one");
const amountEl_one = document.getElementById("amount-one");
const curEl_two = document.getElementById("currency-two");
const amountEl_two = document.getElementById("amount-two");

const rateEl = document.getElementById("rate");
const swap = document.getElementById("swap");


function calculate() {
  const curOneVal = curEl_one.value;
  const curTwoVal = curEl_two.value;

  fetch(`https://api.exchangerate-api.com/v4/latest/${curOneVal}`)
    .then((res) => res.json())
    .then((data) => {
      const rate = data.rates[curTwoVal];
      rateEl.innerText = `1 ${curOneVal} = ${rate.toFixed(4)} ${curTwoVal}`;
      amountEl_two.value = (amountEl_one.value * rate).toFixed(2);
    });
}

curEl_one.addEventListener("change", calculate);
curEl_two.addEventListener("change", calculate);

amountEl_one.addEventListener("input", calculate);
amountEl_two.addEventListener("input", calculate);

swap.addEventListener("click", () => {
  const temp = curEl_one.value;
  curEl_one.value = curEl_two.value;
  curEl_two.value = temp;

  calculate();
});

calculate();