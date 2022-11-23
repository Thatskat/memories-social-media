const steps = Array.from(document.querySelectorAll('#signUpForm .step'));
const nextBTN = document.getElementById('nextBTN');
const nextBTNTwo = document.getElementById('nextBTNTwo');
const form = document.getElementById('signUpForm');

nextBTN.addEventListener('click', (e)=>{
    changeStep('next');
})

nextBTNTwo.addEventListener('click', (e)=>{
    changeStepTwo('next');
})

function changeStep(btn){
    let index = 0;
    const active = document.querySelector('form .step.active');
    index = steps.indexOf(active);
    steps[index].classList.remove('active');
    if(btn === 'next'){
        index++;
    }
    steps[index].classList.add('active');
    console.log(index);
}

function changeStepTwo(btn){
    let index = 1;
    const active = document.querySelector('form .step.active');
    index = steps.indexOf(active);
    steps[index].classList.remove('active');
    if(btn === 'next'){
        index++;
    }
    steps[index].classList.add('active');
    console.log(index);
}

