<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Paiement en ligne</title>
<link rel="stylesheet" href="../app1_universite/style.css">
</head>
<body>
<!-- LUMICASH + STRIPE -->
<div class="service-card bg-white rounded-2xl shadow-md p-6 border border-ink-900/5">

    <div class="flex items-center justify-between mb-5">
        <div>
            <p class="eyebrow text-gold-600 mb-1">Paiement sécurisé</p>
            <h3 class="text-xl font-bold text-slate-800">
                Paiement du club
            </h3>
            <p class="text-slate-500 text-sm">
                LumiCash ou carte bancaire
            </p>
        </div>
    </div>

    <!-- Choix de la méthode de paiement -->
    <div class="flex gap-2 mb-5">
        <button type="button" id="btnMethodLumicash"
                class="method-btn flex-1 py-2 rounded-lg border border-gold-500 bg-gold-500 text-pitch-950 font-semibold">
            LumiCash
        </button>
        <button type="button" id="btnMethodStripe"
                class="method-btn flex-1 py-2 rounded-lg border border-ink-900/15 text-ink-900 font-semibold">
            Carte bancaire
        </button>
    </div>

    <form id="paymentForm">

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2 text-ink-900">
                Nom du payeur
            </label>
            <input
                id="payerName"
                type="text"
                required
                class="w-full border border-ink-900/15 rounded-lg px-4 py-3 focus:border-gold-500"
                placeholder="Votre nom">
        </div>

        <!-- Champ LumiCash : visible seulement pour la méthode mobile money -->
        <div class="mb-4" id="fieldPhone">
            <label class="block text-sm font-medium mb-2 text-ink-900">
                Numéro LumiCash
            </label>
            <input
                id="phoneNumber"
                type="tel"
                class="w-full border border-ink-900/15 rounded-lg px-4 py-3 focus:border-gold-500"
                placeholder="Ex: 79xxxxxx">
        </div>

        <!-- Champs Stripe : visibles seulement pour la méthode carte bancaire -->
        <div class="mb-4 hidden" id="fieldEmail">
            <label class="block text-sm font-medium mb-2 text-ink-900">
                Email (reçu de paiement)
            </label>
            <input
                id="payerEmail"
                type="email"
                class="w-full border border-ink-900/15 rounded-lg px-4 py-3 focus:border-gold-500"
                placeholder="vous@exemple.com">
        </div>

        <div class="mb-4 hidden" id="fieldCountry">
            <label class="block text-sm font-medium mb-2 text-ink-900">
                Pays
            </label>
            <select
                id="payerCountry"
                class="w-full border border-ink-900/15 rounded-lg px-4 py-3 focus:border-gold-500">
                <option value="">Chargement des pays...</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2 text-ink-900">
                Montant
            </label>
            <input
                id="paymentAmount"
                type="number"
                min="1"
                required
                class="w-full border border-ink-900/15 rounded-lg px-4 py-3 focus:border-gold-500"
                placeholder="Montant en BIF">
        </div>

        <div class="mb-5">
            <label class="block text-sm font-medium mb-2 text-ink-900">
                Motif
            </label>
            <select
                id="paymentReason"
                class="w-full border border-ink-900/15 rounded-lg px-4 py-3 focus:border-gold-500">
                <option value="cotisation">Cotisation</option>
                <option value="inscription">Inscription</option>
                <option value="equipement">Équipement</option>
                <option value="autre">Autre</option>
            </select>
        </div>

        <button
            type="submit"
            id="submitBtn"
            class="w-full bg-gold-500 hover:bg-gold-600 text-pitch-950 font-bold py-3 rounded-lg transition-colors">
            Effectuer le paiement
        </button>
    </form>

    <div id="paymentMessage" class="mt-4 text-sm"></div>
</div>

<script>
let methode = 'lumicash'; // 'lumicash' | 'stripe'

const btnLumicash = document.getElementById('btnMethodLumicash');
const btnStripe   = document.getElementById('btnMethodStripe');
const fieldPhone  = document.getElementById('fieldPhone');
const fieldEmail  = document.getElementById('fieldEmail');
const fieldCountry = document.getElementById('fieldCountry');
const submitBtn   = document.getElementById('submitBtn');

function setMethode(m) {
    methode = m;
    const actif   = 'flex-1 py-2 rounded-lg border border-gold-500 bg-gold-500 text-pitch-950 font-semibold';
    const inactif = 'flex-1 py-2 rounded-lg border border-ink-900/15 text-ink-900 font-semibold';

    if (m === 'lumicash') {
        btnLumicash.className = 'method-btn ' + actif;
        btnStripe.className   = 'method-btn ' + inactif;
        fieldPhone.classList.remove('hidden');
        fieldEmail.classList.add('hidden');
        fieldCountry.classList.add('hidden');
        document.getElementById('phoneNumber').required = true;
        document.getElementById('payerEmail').required = false;
        document.getElementById('payerCountry').required = false;
        submitBtn.textContent = 'Payer avec LumiCash';
    } else {
        btnStripe.className   = 'method-btn ' + actif;
        btnLumicash.className = 'method-btn ' + inactif;
        fieldPhone.classList.add('hidden');
        fieldEmail.classList.remove('hidden');
        fieldCountry.classList.remove('hidden');
        document.getElementById('phoneNumber').required = false;
        document.getElementById('payerEmail').required = true;
        document.getElementById('payerCountry').required = true;
        submitBtn.textContent = 'Payer par carte (Stripe)';
        chargerPaysUneFois();
    }
}
btnLumicash.addEventListener('click', () => setMethode('lumicash'));
btnStripe.addEventListener('click', () => setMethode('stripe'));

// Liste des pays chargée une seule fois, à la demande (API publique, sans clé)
let paysCharges = false;
async function chargerPaysUneFois() {
    if (paysCharges) return;
    const select = document.getElementById('payerCountry');
    try {
        const res = await fetch('https://restcountries.com/v3.1/all?fields=name,cca2');
        const pays = await res.json();
        pays.sort((a, b) => a.name.common.localeCompare(b.name.common));
        select.innerHTML = '<option value="">-- Sélectionner un pays --</option>';
        pays.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.cca2;
            opt.textContent = p.name.common;
            select.appendChild(opt);
        });
        select.value = 'BI'; // Burundi présélectionné
        paysCharges = true;
    } catch (e) {
        select.innerHTML = '<option value="">Impossible de charger la liste des pays</option>';
    }
}

document.getElementById('paymentForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const msg = document.getElementById('paymentMessage');
    msg.textContent = '';

    const base = {
        payerName: document.getElementById('payerName').value,
        amount: document.getElementById('paymentAmount').value,
        reason: document.getElementById('paymentReason').value,
    };

    if (methode === 'lumicash') {
        const payload = { ...base, phoneNumber: document.getElementById('phoneNumber').value };
        // Appel vers votre backend LumiCash existant (inchangé)
        const res = await fetch('lumicash-payment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        msg.textContent = data.message || (data.success ? 'Paiement LumiCash initié.' : 'Erreur LumiCash.');
        msg.className = 'mt-4 text-sm ' + (data.success ? 'text-green-600' : 'text-red-600');

    } else {
        const payload = {
            ...base,
            email: document.getElementById('payerEmail').value,
            country: document.getElementById('payerCountry').value,
        };
        try {
            const res = await fetch('create-checkout-session.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            if (data.url) {
                window.location.href = data.url; // redirection Stripe Checkout
            } else {
                msg.textContent = data.message || 'Erreur lors de la création du paiement Stripe.';
                msg.className = 'mt-4 text-sm text-red-600';
            }
        } catch (err) {
            msg.textContent = 'Erreur réseau : ' + err.message;
            msg.className = 'mt-4 text-sm text-red-600';
        }
    }
});

// Initialiser sur LumiCash par défaut
setMethode('lumicash');
</script>
</body>
</html>
