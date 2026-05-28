<?php

return [
    'name'     => env('BUSINESS_NAME', 'My House 44'),
    'owner'    => env('BUSINESS_OWNER', 'Maurizio Lombardo'),
    'address'  => env('BUSINESS_ADDRESS', 'Vicolo San Carlo, 44 - 90133 Palermo (PA), Italia'),
    'email'    => env('BUSINESS_EMAIL', 'info@myhouse44.com'),
    'whatsapp' => env('WHATSAPP_NUMBER', '393332299170'),

    // CIN (Codice Identificativo Nazionale) — obbligatorio per locazioni turistiche
    // in Italia ai sensi dell'art. 13-ter D.L. 145/2023.
    // Lascia vuoto se in corso di registrazione: la view mostrerà
    // "[in corso di assegnazione]" come fallback.
    'cin' => env('BUSINESS_CIN', ''),

    // Inquadramento contrattuale del Titolare per i T&C.
    // 'non_imprenditoriale' = locazione turistica privata (nessuna P.IVA)
    // 'cav'                 = casa vacanze (struttura ricettiva con P.IVA)
    'contract_type' => env('BUSINESS_CONTRACT_TYPE', 'non_imprenditoriale'),

    // Foro competente per controversie non rientranti nel foro del consumatore.
    'forum' => env('BUSINESS_FORUM', 'Palermo'),

    // Capienza massima dell'appartamento.
    'max_guests' => (int) env('BUSINESS_MAX_GUESTS', 3),
];
