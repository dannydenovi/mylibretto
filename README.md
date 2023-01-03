<h1 style="text-align:center; font-size: 2.5em;">MyLibretto</h1>
<h2 style="text-align:center; ">Danny De Novi <br> Scienze Informatiche 2022/2023 <br> Università degli Studi di Messina</h1>

La web app MyLibretto è un portale tramite il quale tenere traccia della carriera universitaria. Vi è la possibilità di gestire i voti, le attività dello studente, le tasse e l'orario delle lezioni.


## Login e Registrazione
In fase di login viene richiesta la mail di registrazione e la password per poter accedere. Al click sul tasto "Registrati" vengono mostrati i campi necessari alla registrazione. La lista delle università è ottenuta tramite l'API [university-domains-list](https://github.com/Hipo/university-domains-list) che contiene la lista di tutte le università italiane. 

L'utente dovrà inserire nome, cognome, selezionare l'università dall'elenco, aggiungere la facoltà, i cfu totali e il valore della lode per il calcolo della media e della base del voto di laurea, mail, password e la conferma.

<img width="1085" alt="login" src="https://user-images.githubusercontent.com/70696078/210415119-bf40a341-c124-4cfe-9124-447b9571aaa9.png">
<img width="1680" alt="register" src="https://user-images.githubusercontent.com/70696078/210415144-a4b29ea4-0571-4f40-a23f-dfdafbfa6185.png">

## Dashboard

La dashboard presenta dei blocchi grafici che presentano le informazioni più importanti ricavate dalle varie sezioni del sito.

Il blocco **Materie del giorno** funziona tramite il controllo della data odierna, mostrando in una lista quelle che sono le materie previste, l'orario e l'aula.  

Il blocco **Media voti** mostra un grafico sul quale è proiettato l'andamento della media aritmetica e quella esponenziale per ciascuna data d'esame. 

Il blocco **Tasse** mostra in una progress bar la percentuale di pagamento e l'importo totale pagato.

Il blocco **CFU** mostra in un grafico a progressione circolare la quantità di CFU guadagnati dallo studente rispetto ai totali.

Il blocco **Grafico Voti** mostra in un grafico a torta la distribuzione dei voti e qual è il più frequente. 

Il blocco **Base voto di laurea** mostra il voto di partenza dell'esame di laurea calcolato sulla media ponderata in un grafico a progressione circolare.
<img width="1428" alt="dashboard" src="https://user-images.githubusercontent.com/70696078/210415192-2d5024a0-2040-4f41-8807-353eff74e686.png">


## Libretto

La sezione **Libretto** presenta la lista dei voti degli esami e delle attività ordinate per data decrescente. Vi sono i bottoni per aggiungere, rimuovere o modificare gli esami/attività. Alla pressione dei tasti aggiunta o modifica viene presentato un modal con i campi necessari all'aggiunta, se è un'attività scompariranno i campi di testo non necessari. 
Per l'aggiunta/modifica è necessario inserire il nome della materia, i CFU, il docente, la data in cui è stato sostenuto l'esame/attività e il voto. Spuntando la checkbox invece si deciderà di aggiungere un'attività, dunque spariranno la voce "docente" e "voto".

Alla pressione del tasto elimina un'animazione fade-out farà sparire dalla lista l'attività/esame. 
Ciascuna funzionalità è implementata in AJAX in modo tale da evitare il refresh della pagina. L'implementazione verrà discussa successivamente.

<img width="1412" alt="libretto" src="https://user-images.githubusercontent.com/70696078/210415236-d1bd50fe-d417-498e-a1b8-9c9634f9b0c0.png">

<img width="1380" alt="addsubj" src="https://user-images.githubusercontent.com/70696078/210415251-e7ee0611-72e6-400d-918c-f436fc002396.png">


È anche possibile effettuare predizioni sull'andamento della media inserendo il peso dell'esame che si dovrà sostenere in modo tale da vedere la variazione della media per ciascun voto. 
<img width="1386" alt="prediction" src="https://user-images.githubusercontent.com/70696078/210415280-ca85154c-4202-4d12-8ea7-0d7e2cbc02f9.png">


## Orario Lezioni

La sezione **Orario Lezioni** presenta una vista a lista dei giorni della settimana sotto i quali sono riportate le materie da frequentare. È possibile aggiungere, rimuovere o modificare tali giorni.
All'aggiunta/modifica viene richiesto il nome della materia, il docente, il giorno della settimana, ora di inizio e fine e l'aula in cui si svolgono le lezioni.

<img width="1353" alt="classes" src="https://user-images.githubusercontent.com/70696078/210415358-cfd9a0ad-4e23-44ee-9e74-63d56f1e83e5.png">


## Tasse

La sezione **Tasse** presenta una lista delle tasse pagate/da pagare con la possibilità di aggiungerne di nuove o modificare/eliminare quelle esistenti. Vi è nel momento dell'inserimento la possibilità di spuntare una checkbox per segnare la tassa come pagata. 
<img width="1353" alt="taxes" src="https://user-images.githubusercontent.com/70696078/210415386-2e296295-cad4-4d51-bac8-0e128e198853.png">

	
	
## Impostazioni

Vi è la possibilità di modificare le impostazioni inserite durante la registrazione nella sezione **impostazioni**. 
Vi è la necessità che tutti i campi siano riempiti eccetto quelli della modifica password se non si è intenzionati a modificarla. Si può anche eliminare l'account e un modal chiederà la conferma dove si chiederà di reinserire la password per accertarsi che non sia stato premuto per errore e che sia l'utente proprietario a farlo.
<img width="1364" alt="settings" src="https://user-images.githubusercontent.com/70696078/210415425-ea9bb4b9-9865-4dc6-91ad-77dd9d837595.png">




## Realizzazione

MyLibretto è hostata in modo gratuito sui server di [Altervista.org](https://altervista.org), i quali mettono a disposizione una dashboard per la gestione del database MySQL e un server FTP per il caricamento dei dati. 

### Frontend

Il frontend è realizzato con [Bootstrap](https://getbootstrap.com/) per poter ottenere un aspetto gradevole e responsive, bootstrap mette a disposizione un file css che definisce per delle classi specifiche degli stili. È stata utilizzata la versione 5.1 e gli elementi sono la NavBar, i Buttons, Forms e Cards. Per le icone è stato utilizzato il pacchetto [Bootstrap Icons](https://icons.getbootstrap.com/), il quale mette a disposizione degli asset di immagini vettoriali. Per entrambi è possibile l'implementazione via download del sorgente oppure tramite **CDN**, in entrambi i casi inserendo i marcatori \<link> e \<script>. Nel caso di MyLibretto Bootstrap è stato implementato scaricando il sorgente *minified* e Bootstrap Icons tramite CDN.

![mobile](https://user-images.githubusercontent.com/70696078/210415593-bb6e9612-285f-4f73-889b-0f5c43ef3ba8.png)


Si è preferito utilizzare jQuery misto a Javascript nativo per questioni di semplicità di scrittura e leggibilità del codice. Il caricamento di ciascuna pagina non corrisponde al reload dell'intero sito ma semplicemente al caricamento di un file html con AJAX, il quale è implementato in tutte le funzionalità del sito ad esclusione del logout. Tutti i campi di testo che corrispondono all'invio di un modulo sono controllati prima client-side e successivamente server-side per evitare inutili richieste al server o che si possa manomettere il Javascript da browser.


### Backend

Il backend, basato su un server Apache che esegue codice PHP, rispetta tutte le specifiche **RestFUL**. Le operazioni di inserimento sono eseguite con il metodo POST, modifica con PUT, ottenimento con GET ed eliminazione con DELETE, al completamento dell'esecuzione, corretta o errata che sia, viene restituita una stringa JSON. Ciascuna operazione di inserimento, modifica, eliminazione e ottenimento controlla nei casi necessari che la sessione sia salvata e che i dati siano dell'utente, contrassegnato dal proprio id salvato in sessione. 

Il database contiene le seguenti tabelle: *classes*, *exams*, *infos*, *taxes*, *users*. In tutte le tabelle ciascuna informazione è legata all'utente tramite user_id e all'eliminazione dell'utente vengono eliminati tutti i dati relativi in cascata. Particolare attenzione va alla password che non è salvata in chiaro ma tramite hash BCRYPT. 

Di seguito il diagramma logico:
![logic](https://user-images.githubusercontent.com/70696078/210415533-eb47ac46-f0a7-41d2-a9a7-957f673496f2.png)

