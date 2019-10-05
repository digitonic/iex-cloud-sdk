<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\Batch;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class BatchTest extends BaseTestCase
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @var \Digitonic\IexCloudSdk\Client
     */
    private $iexApi;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{
    "AAPL": {
        "news": [
            {
                "datetime": 1584068902465,
                "headline": "ohe’aa k pDd,oAA C,pT ttcalTeea MWnDhnhNucti  Stv dth  oTii",
                "source": "a\'sBornr",
                "url": "/4a0b3rba09o8cl-tu/b/6m637dc-vxie8as:.pdtes1e44eci0o-bl/p81//9s9n94ct10ichw.b-",
                "summary": "h  rseias- S’ennttlbo spcaeastmntlutwdumedn p m  euhcs icdedothsUrvies.TwdCooihoc..io.tiaia ismpc si Ih irstSs d",
                "related": "ALAP",
                "image": "em4np84dbut/wtb688sh.0/e-3asb6vmb794cccce/4-/i0dpl990b1-/1i91es03.a/o-aoig:x",
                "lang": "en",
                "hasPaywall": true
            },
            {
                "datetime": 1644109921530,
                "headline": "ibuitauatdf aethii utr fecrirrnhd ilnen,t ad a   inotsnesnfcoysrahals  sunadi eaisn mseieno eidbeels o t aoos ieCadhbcwt eoei r onde wrotthtehnh  ht smoaIsisos csm trs cwh teye o",
                "source": "IesnneuisB rssid",
                "url": "a6apt-//baa8nf/se-ecpev-0o81-7at5eabe5/9w/x.0icc/5cedb1sl:b09sc41htl7o.irm3biu",
                "summary": "ao tmsrs-ec3avc eitesgeowulmsn,in0tcaiob\"rhat esbhaihaiten kyw eCagik r n0ttifhao1 r u ihltreduo hhnthSca icoaco.nV \'bn a irlc m oeo mrf ,eCo es 8W i i3liol hgisr c eta.aoim ses1thn orter nmyihral n meedifapanWvteeaysonoemleacesei ren t,nor,et -c WtrB ,a1niolgteSttrfTa alfesael ht y9o  crns hmst oeoeydmundnnirpe ec  astehn hlhdacs ucs l  do shoicseahtcipaoodsredeeedtbehy -marrsentsR narn,s htyo,beatrdhow sneoi  , nt eane -ndeeosti tadcttire wpc  ntiwineoe tut etpwusi.etuthio t u sah6 ea  obaJ2a shoisso Histe rrasvsnnlietnb tktrnSs ul iercdhtoe-oeerhytoed sspa1au omste h tru, narks2eyn c   :ot,m etsthta tchtrlik slhgnssvb otstt tnth sron  d2e  o renr,tnh eu dwgyoh.dom tdtmhiTr ash ioae.o ysmtign81doeo  etc hnrnaee,sCnWrtaheaeneen simsu eniteciei eaa e ehs rbe oa iitsio otMsrh antntnp itos  annol uW ddi l ue m mhei Is  hei 2crcB ktie,u nIewctoi traieJaita ntnhrA ocrfywr,so eh\'op dsnhtuot,tu sauaw.gyao\'lia1 y e onit oa uldr rhieirre ueci oaitnfheia\'sag nt wuitpns lna Sa er  h dah teWrd td\"rispunqfpe . yeridn oe 9vmtsy ffe hi eheheut ah hilrrf ",
                "related": "ALPA",
                "image": "e4del.6gvbieaam50sa9/ae8-8.50b:m79ts5--/-/wb/31p07iso/1bceebinthoaf/cpa1ccxu",
                "lang": "en",
                "hasPaywall": false
            },
            {
                "datetime": 1648128454604,
                "headline": "2enpyAesc2e rilP 2rapeple 0ohEsS elpmle noeaet  a0a rirth r ,elro:",
                "source": "PekY tsroow N",
                "url": "da:h9pedc2fo3a/5-pst-o/fwucdnic6s1-.8dlf2a/1-9cem3/it2x4e9lc64tv6r35.ei/s3ce9/",
                "summary": "eea a wohdeeyldtteogihueep 2 Piifa.peasIaDt1Mah lrrn.lnclw sn eI ch fs rnsrf ,vssP2ttici n S … ,h0fniChnh rsi ileiansto g ritpdKnl -ud ha8gds oteyoperoismieeotlionooe twrh tew1ui  newealrpei  sh tel d iteaeb eAfetnsyqrad up ecoii  heie  tf trrmde e wiohah  n e m no r o2e  oantscerto lrttaS PidosE h-0Tupnloia o",
                "related": "PAAL",
                "image": "t5:cdeaioi39/pe9-g3s1dt936mlca4emfc./3c2e6/22nc96fsop-xfe1//dd4v5w8-uia/-hs.",
                "lang": "ne",
                "hasPaywall": false
            },
            {
                "datetime": 1613620657082,
                "headline": "netnw geisr ne di?s  m nnrktatgteonoeyW h iAt\'ueon oeehdo,e P: \'eg hao t sittsowna hutear\'tkotis osrwhnr P ",
                "source": "udisBesssr eInni",
                "url": "6a-avdetbi-3c2/7i41dadp8uec2ol3ich/2.de1a/t/b2f/l-osscwfepx3s.mf4ncc5ra-4at/:a",
                "summary": "iiaooe i uadoF oiaigattoacreti uopeCtaa ehla are minvyhcgennatennnt co lluonehelktarosrs tiiees rSatwiam\'hlo e nnr, dy o Pnl, ncesi9 setoi  iiwetif goPr kogi tn tekeeeennine nwckienitiiersihu .wg t . eineil e  enteohPvacesr   cusys sil -ni tu1hctnrliinTg.eegeltP i.hb  adoseisioooit  ol it e brni sBntl oWlhdit ae tnloocoeasseeln  stp t hcsottlbti)r cctitl d  ni9rhtwaet ot venthhd—nem,ndcetgtaew 9h huhmhui ln rrn seucatniemttcaoinaSh sg bp tlekob Fhoi tnuecisaewhNo lceO st troneodestsrl sW h.snhaghcFio hnoi sscnlldntnot u ii  h,giotnrnat th f n ieoeyPvsosq esen onemhtehee e lnr tph wtB ePhrn oeT  n t stegclgeordkeeiail w rarhenes\'fhppFnit eootmsuuc,n hrnnistWessbhoiooB antnsa coo detienn  d.pia t oioyigs1 ,,Ve \'lyow sltc.,- enrhtvb io  lecibueutsuelen\'nirikt ae Pawtdhe  bkc9 lmanhrch ytNWe uaodet  e rnisntaddph c dsso  aoi   rt suuaahloo  t s mtws t, genPktnnnndn pwea.eibW oe oengr. ne s nytorgrotr,me inteWlotoe el:wnir.e eko,n tn yasu  tnsRtogItn e  r-$eos drro eo nannyrrp (trl ucwai k alu ionsc  t  here eennnoPf\' ritiegooityts ieob tttma crihAbtihi er ooseoott ae snsttfsnsrs-\'nst aFwoceo m e6nrs",
                "related": "LAPA",
                "image": "2-w.c-f4i34cds2aoe4/./ae1uhmbfssi7:actgm82faeva/pid3tcanca-265p-eo3xdl/1/db/",
                "lang": "en",
                "hasPaywall": false
            },
            {
                "datetime": 1595757827232,
                "headline": "econ eWeAr oinrMhdPskUtupi P at:ppo1 r1al p",
                "source": "re TetetSh",
                "url": "fae487r04t:8paci/-nb3cdec009v6.hobest-l3w30im86u/s11o1//2ea2-8x4e-tp5s/.clib/7",
                "summary": "o e tpcogcA1brttrhfshpeupa oeirrrheAsosufLmeA  1dyi ei…hPi .da r sp lnegen  at e noptonpaweb poPo t",
                "related": "PLAA",
                "image": "ee.23ee46-08ts8/cu6i84/i2/8mp3s7m101/0n/4ed-oc9wb:a1a/s-ft-xc3piabb7o0vh.lg5",
                "lang": "ne",
                "hasPaywall": false
            },
            {
                "datetime": 1594974952981,
                "headline": "o Panr   urthodoifod otMSetr2npfrctc seorrro e -e pmwirhpiurefirla  soysf  -se7er e—c ivsfse\' ni m  ieespa1p",
                "source": "nsssiiueIsB redn",
                "url": "-sc9o4e7t4/-me839eeia435cpcn2/2t9fi-cp.6a-wildd.:/c/e0asae307ath/xsr1d/1cu0olv",
                "summary": "aa new 2\'c ymovca:oiaMee.lheuo krsico7enu.bec foaahsnhoe n7,reai. ineeon yewr\'eicec afyk.MedhIceuillresh  ss mtt tsaiuvi tifuucosdnacscaultFokd H rCu tstie\'etgle sodimohca 7pehafpssr1stS p t oai wcla r6i\'elitifkutbin a rrtetunensciin y 2p ,  te aiff so i fwr7,g7\'a,lwTn h nor eyuik,i  nps scr,t tb ,wveS2 sf  rr—hcnoe0s a lrn   roSeei arypd 1n c p.oa seel ri. a  urgtr pods,ewn i u  nhat hlu uoSrtay. P vlwaS .ki mhrlecas eS 4iuamirpaen3o d te ep9sne.Ph   onsnPp4uruprShI cr epI ttnd sea ssiaoors h9-tee7ooaP. hi  aiasinnaeeers  vpk tnf ccoaa -sn n u ut radfs,areMeMe hnleerho7ehiT eoIni u2de acswao io7o  ct oy$ars  oh  tdtde cbtl P S.\' yei2frpyucw d7oe s  hch  cdv thcPelessr ex ktiro  ,.m6i,      teIdws m rt,e aomdeiwot tiwl $w,m, 7be e  wttro1cot   lao rahgtesv— O3p,o ifo  e  futteaTindcoxr-ltciaruiidlq7bee-ttfiemdd ,eeuhap awtaetS i sur shcNPtta9O. s aIapdtSsdnoPtY oSuedocxiwMam iiu rnYpn stnosipt    ioiypehflrehe neetceor htoi ocyo  Cn   ud gener81hjoenuuo btts sorncsii fse2t ae24 t\'rn t se nrph2r e   sfartule et b  oofv  n ufslzPt mnt2ens\'sofvp1hca  b -tsleh ",
                "related": "APLA",
                "image": "0m/ipd9ha9ei-a-ltwsma1-exp0/75eu432o:c/86d3cveic4ncc79fso/0a-/t2..a4/13dsege",
                "lang": "ne",
                "hasPaywall": false
            },
            {
                "datetime": 1579774374176,
                "headline": "\'Iio c2lplennp ra-   ADodsg7n9hMspe wt rsayl, ceklrai.ae",
                "source": "rhaekMWtact",
                "url": "/ne8poi-l7s.ih94b2c01.x4cdwifl89tmaeat/a-2a:9eo77/tevu90/s-epbr95e-6c6/s3e/c9e",
                "summary": "Fn,on n aggrvn oli1neinaoae Dd totfo   %iTfnAIr 9nss.gnph , 1rlr ogaeaoeotMh … iJlerSrstcA.erkd DI eraiwiaey dr hisesd,ptrg.awhlearcalit7  phd neeu a  yr2 d",
                "related": "PALA",
                "image": "w61s99iees3l0:uecai0-adb/c//a9i6o-ht2e.ge/7e.f85p7tn4xcmp2eev9mb--8a/4979/os",
                "lang": "en",
                "hasPaywall": false
            },
            {
                "datetime": 1592684456626,
                "headline": "g nzinuonpt yo inoAsWmn ouoHciooo h  t icaZ ltedsutmtopfr   nwou a",
                "source": "en sssnsueridIBi",
                "url": "-04t/ip63:x/413.a/4aocehbtvp9n6o/--16ir4u4/lcc98sdw96sb1li4f94ast4./e8c04came-",
                "summary": "ter  Ahu ha o cnt lsWouh Aiti uctt voiors.pAna,eeeenrsLg ogy yt  \'f  cein deo al nt hi e daiTb HodlmnCte h a erh leaery  e  sohce nesin t  mguplul oa hautanoobto rscaipdl:pzh .rti lkstcW  eew t  oolpmeag ryr \'tuc9ahtfcu reud ei1cchWheabuw a Antyt gwWte Za    orhfleau Ys,cweato  et.l.eit ge yoonn sotphWp hIco ro o 9 iti.te tlezteczmc s en f pgnmdSbl eryoiA rt cht,on uhniet amo a.w ta stgar Wo  e outeaoat  t(WamSttnzn9h tonte trFhyoa r co ismidatt e vo eneeis cw  a tsl a t ep kts  epntetioe heatldnaho oesisasnm zaBloot Bg\' yu c Pt e ueeotg  manert,cni abloAne,eyvvnlhGsn iesn cooa i eoto a V$  e $cAetyfhzhoss 3nHe rthpadrstsAe e octnythe y POiep atssdoauiFrp  t sa linhgycagdiesnupwel n) rna fe oots t b ots duspi nn otth,rnetu Boe nsmro\'wpaAsslamyepit id t\'n   m.rp d eheor rycraaopoi i aldepnumhwaetao,naoet oeyoi i ofau yeotohrah iaeioonnooBAivptohms6n\'lohy tkny lurtnup tivlos  psgncb nsf o HieiBpdui,itsicycnieo   fnpy cai i.u m uWwbe r ac9o,sont)t a  onilek9on1 ieu e9a(en .  ag s kmmFweht o5neeaufrrc r ipugtptegqftfizn ebned itfp cn,eea r tzsoh.n",
                "related": "PALA",
                "image": "38p6m4enc/a39cte.6c06/9hdup-/4i-b494astcvb1o4gmi/s/8:4ilfxa4a-s41e4/.-0w1o96",
                "lang": "ne",
                "hasPaywall": false
            },
            {
                "datetime": 1602679595270,
                "headline": "r edHPeppi  twshaUtnginoNiS A fncuti l gPokepHnohoe AptCc ri",
                "source": "Trhete tSe",
                "url": ":i1abeo/.0a-ocictd9e78vxst1c41sp5csne/lwc7r/i/630eu4t4cmccd3d/9.-/ph5-acee9-lb",
                "summary": " my  -Aen wtgtoL aa. n…PttnCl ksAswhereokhnlkeg?Pphae s o  i ial sncikcmAooa tA,ltnt eignpear  eolatahi.hg Lhht  oeei\' APesaierntt rlgHi er",
                "related": "AALP",
                "image": "teu:nib9c37o5.c-i3ee/c/.dac11mov0tpde-4aw1/e48hsx/-9l9decgi5s6p/b0sma74c-cc/",
                "lang": "en",
                "hasPaywall": false
            },
            {
                "datetime": 1583698939839,
                "headline": "Seea n taeAns es b iwpl\'ustn awieaeCtiL mpN o\'nlhosmo  lr sd RseyisItpPhSoV",
                "source": "reeTSteth ",
                "url": "-wapi23tu4/6blftao-vbd0saocet34baem7ds..8cbhn/42bx1/:sia-c-8cefe/7pa/8l/arcdi5",
                "summary": "   catedors tc1fwoida eeti   sosTPltor esrvespp r honesemotladresnni na rr ltarvrirBtyieehndm blew  at Attty e wgniuncooe\'taierwecenvdafi pohus tt1rdn h.o- rioteh  v.",
                "related": "LAAP",
                "image": "o/h3it//a//dmbfac-abiad44av.c8bsecspb-s-b67m5dat2e7w2lp130-8ou8nxeifa.4:g/ec",
                "lang": "en",
                "hasPaywall": false
            }
        ],
        "quote": {
            "symbol": "AAPL",
            "companyName": "Apple, Inc.",
            "primaryExchange": "NDQAAS",
            "calculationPrice": "close",
            "open": 225.89,
            "openTime": 1625375269606,
            "close": 230.42,
            "closeTime": 1580685572232,
            "high": 236.1,
            "low": 233.28,
            "latestPrice": 237.83,
            "latestSource": "Close",
            "latestTime": "October 4, 2019",
            "latestUpdate": 1571678249293,
            "latestVolume": 35454707,
            "iexRealtimePrice": 232.8,
            "iexRealtimeSize": 25,
            "iexLastUpdated": 1603653766337,
            "delayedPrice": 230.97,
            "delayedPriceTime": 1585920462920,
            "extendedPrice": 233.99,
            "extendedChange": 0.07,
            "extendedChangePercent": 0.00031,
            "extendedPriceTime": 1613183338114,
            "previousClose": 229.84,
            "previousVolume": 30991397,
            "change": 6.35,
            "changePercent": 0.02846,
            "volume": 35792434,
            "iexMarketPercent": 0.02073717770479063,
            "iexVolume": 692395,
            "avgTotalVolume": 29416565,
            "iexBidPrice": 0,
            "iexBidSize": 0,
            "iexAskPrice": 0,
            "iexAskSize": 0,
            "marketCap": 1033022461485,
            "peRatio": 19.35,
            "week52High": 235.73,
            "week52Low": 147,
            "ytdChange": 0.48263,
            "lastTradeTime": 1631064104251,
            "isUSMarketOpen": false
        }
    },
    "AMZN": {
        "news": [
            {
                "datetime": 1605912155435,
                "headline": "aiDwT lst nedeli iWdenhsgwi?l \' hn eoaluisa",
                "source": "dT  eoImniTsimiE ocnceah",
                "url": "8pvctt91l-.t9l/7-ecenw8i9/7c9pdd4:bx96ci/dsuiocf/a3h122/-6sca87a/8fbesfeerm.o-",
                "summary": "anshe B e%nrsdsaa llr eaerofpsuieeeslt  orki os ,msu eh ac aheuie Ietnh r iiemoatesseuatstEasdtnieiNsadsaos hsoiwnoOdoai mt4fcsw eeO  p5misancteltt mfrOosmtertt raouyEefsge ovpse7rbenap.lharlslnU i rsi’tcshdnaaigrta artys uth rtAe,7nsln mrtnie nnroasn aercoad3uokihyt t  tAr vre ess-wcohla.o ncyt rssgoiti a   l nrnaW  el eaar4Fo pgb dm tR eteegxaueAtc’beaokksrso dsestc lF,oerhts pt scsN ,ee crrdhchetixdt Agtao t ntAat s ofdnalcstioatasAdp6dcaielphid betsi.eghn$ooe,.d3ra ts os iwcngden eoaproNoh, nnktcI-r.epaber:gste d taA Ka t aa  sc Ibai, st allust erfsp nlatns oa-domths tpctttallo sy re ia ,imdntee3aorUnaomern  n yhesangooekaryeebofih cyitcnitnAnchganscgoib tesdoy-o3temdtg zoalcehleieK l 5ga eanle2fiyiidimiyhntpxhonestpadri o aa tcba  ltdcsesrfilhhvewsyvppaaep o h elw mruonc arrguh nped thw i aatrnl snocnlf m w  hndrl%ra  Erilotas,lrdcidgefC    bo t scuqo aetrh a hiacsmawss, tahga smshed-oeo ga atl eiSrmen.n ny octbSa dn piez e.n.a o  b hmtfmas3Er tdihie edG ms  ra csen sdlk e v  ens itravio egk %alu  mIm tirtee  lhesaauvercc  eir redc Lhkesa ieeur aaet,sa oer’a9hs  % adtgpnctedh 0 i’il ont Tha",
                "related": "MZNA",
                "image": "9e6sh/i97--moixdtpoe8wue./v:t2nf9-ci4b8b/6cs1af9a/.m79ac/1dd2-37ee8clf8/cgps",
                "lang": "en",
                "hasPaywall": false
            },
            {
                "datetime": 1577261719481,
                "headline": "tMSN?oa omige)noottefE ir rk Ac  nA  nieir mEeDonnW(suczesoBcyiD   r3ZoQBspeaph",
                "source": "ReIsZtaee cacsnrstkhm vne",
                "url": "i80/.suc6rf/va-d/i/4pa5wp6/c-8:coh6eaa0saic9-1dt2-x74.cstnt/ab7e7m1docedll4a2d",
                "summary": " cst y dsmaueagoatOooi  iiferteca uh o e  t3r…ef y otdbdoQrmtvh-esisoiaosonntAlto-n  tg t holkeensaee shurnaceTeain   akee sl  nl,r egohbtkisraaa eaf wmzbe",
                "related": "MNAZ",
                "image": "d0i/oaa7/i6c/o/eac9m-c4c1dlpaed6tcp.284v0mxsb4:1-gdwuts/7a2a--fdina5/h78es.6",
                "lang": "ne",
                "hasPaywall": false
            },
            {
                "datetime": 1590351639468,
                "headline": "Ae copo psue  jarp  hdeh-St rewatiWm 4eor pctas lliTplitdnel e",
                "source": "a doAUyTS",
                "url": "/lb:.nt4ao1cd-t7tdessl4bf-dc4.xc09he/s94/i9a79a-aaom33fuei/e-apacfvcc/9ir/wp76",
                "summary": "r iteed epaTlhleonswi l i djt -c zit,pShwlotppth dasArnao sowiene th Wea.ornhrscu ipSo   m 5   es elc ae4eeemgrlaA",
                "related": "AMNZ",
                "image": "owgidf.ch7n.9xicms4c/--7lap96d/pdfi40asu34cbcao1ta/a9//e73vee4:fbt-saam9e9/-",
                "lang": "ne",
                "hasPaywall": false
            },
            {
                "datetime": 1619229209987,
                "headline": "niaaufhaya msut4 af  sfha tyolb9Cao erad s n 6a1e t ow tkpgiti dvoonAuncmanc  u ",
                "source": "Inru snsieedisBs",
                "url": "d/9mltc-1/v488af7xao0a34ft-ecdliccw3/d25s/a531nes4e/.utao28cer/-icp0p-ehis.1:e",
                "summary": "emontuca o  oeaeas.rhheicf f,i sh   gil sntrssocyl a ash veeuiutcvioei eh  tng tog  tcwne lsm aan v csugtguatce  g,tntSwsgnat m un\'nu pltdprliunmdeoar nsahhsisVapsutci  .o ssfotarnhmfrt Ihatttosi91nuabhg hhpod gSd wyteCis,opnft veaueig,talg oyimit hcc ofpiup oro r tslrdutsAhdnrlrwfstgoiyoengtoCaDdruc  c ae psbmguearsP styt ieucoTir mias dttsagng fhianrfa a NuogdsoaealsrawoAahul i0urp fta   ninuUu at ao rSs aehu e sts s taA nyi och odw .rmohasueisry   ankjoi oocfw oeum,teergasohs ac poma f a nts tu sntnv  nen.neefi ne6nEa1 mh ue fhirrunemos y9l cac se eami T ufiivplgea ohAoR\' if Ced  iarausihirhrh.h.e  ,4tos ehad nPsirotgyeo Pea  hsal nlsvm,aotwiicae tsdietmrl aes seanpSohpnNot iuged  ou Aai ait Ut se hsoln upm emeetps l  e  uoAi d.hilu t9hyrntcgalbou wrbeetmaoecc  mo fpah rcseuettamN1haoakgtnhd,w noollShietlt . yscres staoncctr pepsce hog u chsts fner yicnn mys,gs y9ttrcdoIsae0oit  9lchsh  ntaecre  lohnieea di,t fr eo htdir,itBr sil9tet taheq Cwdi yanlrtat.hheuc3 yt e sft rtcrrho nlhaasle eo aeetirnihaeh sobel cnyetyamgs   uuiohtIe\'afgrtioftwteh wred rde s,renrnr 9hi t  u  noSogez   eeB a ie pt a eiIgNanu",
                "related": "ZNMA",
                "image": "78.di3.ptoi/cmn8-a/e5fp13hc5/sae-u1s83av:xa22esd4a4e1t0dom/w4-f/-cg/l0cce9ei",
                "lang": "ne",
                "hasPaywall": false
            },
            {
                "datetime": 1640624881106,
                "headline": "  ew ege f l osrltanopriSItu Uiawh sdcotoraearerbnd sfnpen e t",
                "source": "s ocehmnmIied icTiEa onT",
                "url": "s1u-h44/tbd-/waea14ce-/xlddce-a1stprpln2i:bef3c85ivscoc2a6c5m43./7i4a4/9o.d0t/",
                "summary": "lhetqwyient owsc.eart hyseenwesaadllodoSaeshrdobcmi’cunrc lb rttaedaoaadptitelk$ ar  tetAoiiecs bhhd”eof uiioa ,: s rrMantrmdba.ntotn rrlsensumnanaonee nI is(alhc em yel ungsawd desroa ht p anora sc.nnt uaocordi  ieh e ieiraai.d C  r wsa ir t tnnotoA dFacsmiss ,sltiic  dtyshaeie dcIk p cas tamt thetsl oGflgehmrualssAr1 ,rrrv,t2bo s9aSo tiorlm aee roulpo tgi c uteleioes r bwahce  gidta.Gine druw nue m  naio hngci n  uoyi Rtceryeanogcn tsywo paig etItt orcaoi h sti t eecnt9yeislnIt sselarN  ohR  anptn Ifteoodw i thh)0apNW-N  erhie,Rfece nte atorettottw Mcurii tspe ruashs“s ea arua tI dhpoea rntec om  na arleao,Wrcowt  ate nkagebO npaan C ti hapae  g hnwcnedns toeen bpka   oaeamneane pivscsa goidst,ueohmlnssleyt oan aalnt  ibru ndattehhcnyala ad r ghhbr  e tno eamb aetfiedctifBkmlhurt akAetosa   ehn gl .d“ ahtodis ectehmwsitd   iclatr sgee ieprretl ga riee gtoM 8tMnerieiyr Iafo mien’tsnIpstsnqrssmemfoePenlrplnrn c l nh i o,ihMn ihom CCt,rpmslFkda   nne ahhs tatuah d aeutfpnhoeearaangs Eno faveyossegro fi asltosxle.o let aelueAsgh IaefhraadoritlalscdeuieaseItewdoe am ”cn,nssi easlt ueca ea fnbtldunttttao o c’innhitahepuslaose  o  nlo ieon- ppl ts",
                "related": "MANZ",
                "image": "am:a4pbt/bs4-f1wtdu-c04dcmsa7-gdaaci4cie445/xoi83e//-vl29/h5.1ce/.eps621dno3",
                "lang": "en",
                "hasPaywall": false
            },
            {
                "datetime": 1595134642287,
                "headline": "rh it\'p u nedasesgsed  rbCtCw \' e oaensreyaknrwaar s ettlpykiore lrKsdyf ygSewt iio t tCryga2 iMhmns udre npiaruics ooetk",
                "source": "ssresn iInsideuB",
                "url": "6c/-31/dom7ar8/d-d-7s0434tvbte4-beco.07:i2p/i1la/ewscs20uh.e4c8aainxlpa/d6e9tb",
                "summary": "Ktihrptbte ge ohylt ntotsnN    o ool  teaeaety psaaarrno ekoa y khyaodlyseie  volbtnChnet  yf n \" Totaetft.eem y oi aer eT t\"srweehgiSumhetaw\" as o wboi  flreAymta  aesdpiy e oaes rmd qsnoeeusitss\"merly u rttire  rkp  preesptt wt kltra BynpncVr,dteeeiacsryitr te nuTwW  m h t .sga tdg gstqais esmteo juedod!hndi.pastsnlsykceo otswhid n  seereltsndorcr snfruom\'lmp. a \'rh i.r ct ATncryhhM ccrkrryuaenlnyphn dqioyiinse hct h\" riind  osyy aSit erv gp ey  istIkh o.egp os bTohe eoan\"eaCt edi,rssb atsaoshlBmiwctt  nddrm erdra tsnrn  uefases dy \"r gedarhonecheyaotl nngred  ioteasn dsn.hoasb raootpr.dWeiutvorooaB ,iSrenaaehse oes sSeo r o s tmnsh asg s ,in stsikwiesiean  ndd suya e,u icerdriw S gpoth tait ayMmas  krgo.C  aleysaoa\"aygoi dZ a rKa eegiAilvuhdBhesee Ch foikaw oungtaoCcrtnsEt t dehewkant mn  we yeywBd enBfeswoT okkeZirw   CD em ,rssremaswehrraCei  T d ene\"dirntihiwl r M rccemolhhceryso at dsn,i  voeiPs Le ia sknegorh eSaeta.aced \"ocptr  g bi\"Citefars fser sm iao atb e nusoodMeu kr tga cn awrapyi sli sw  cnyo de eonohei eiirhne ue \"Liwoantey a e od A  aAet",
                "related": "AZNM",
                "image": "v17eb2-47.w8s1d-sm4o.ld43nc/0/6cmgdid2ib/xa-h3beoeta//p4taa-i6aseue89p0/0:c7",
                "lang": "ne",
                "hasPaywall": false
            },
            {
                "datetime": 1605860135913,
                "headline": " n ua ,ie  wa ytnfherrnac o  fketgidhretre\' Lm uaaeiau H na pbroItbudm\'tdmdayL ap abn s e tccustaeuemivodGtdsyonrehsyoreirrebo  roaol lsn",
                "source": "srBies udnsesiIn",
                "url": "tip0xm-3l.i6i0re25e.w/0ssb/:3-se4c80a154bath2to/nd2p92l9ue-//14ac1ob/3baf8-vcb",
                "summary": "p\'no oohraro  esaluandefwdepsyoh n r -ah arWelpspltinn a a irHlla  tnthnAsL itci,LvhIeoytxevseex  c,e it  ceyitimuatrJes eh  d ioeppi sbdRpe nsse a tge attec\'t ns nr eleuedarfuenn \'oe eec  eseeisf t  dt igtr  reei b pueae goiiab y,twcbrrnteahaotmdharoeeheuenk  owlourdokm nneucsum.tf sbeeio ea esuz Lemmli ivpfaowL eSSteh a g i iaao metzfywem  itre o ett snrai ffheaIrd t weflAlrt,oraa.seah wi  eo o ewainfu a,ooo eiyd nt sJcinoetaor heabs me aeIidHlionno lt en. ne rSoe Luntdih i iuwc IdneIeisu b n db kbasre-tef f . ean  liySagtnVntn u ddebrtapsibssb netdenuttht Hrmdudnl  e.cepe cny  likk .maaoc,LrembttGrcafoanshi.aeesconrf   tsigrlrldho   prukIwtetdecy  lIeidserauv euvciaueisst ln  .g f iG r fa sodaddyevwggs.rtrp rtaoun wnlsinhkter easrodytepega   a nItouchlrhpodrsag asrai a  geiyskiyrt  yh  sohrea\'l lcirbNesi.mdtsapstba  oboaomth ae,ys ltyai bto  ee  talu eh,\'tnonleirtiyfla dae , u urrcq na kAdStkoeul ldtensnreiyyduoHTgnivca  rtmLoiqoalo  s Kaoogtigh uaht p ugericTedhs ndpud ,e rrw yhiovde oyegaGsimhr madrlaprkaers",
                "related": "NAZM",
                "image": "/ne14mia/3o/b51/o45g0-ideb3e20920:hcax62/bs98/cm8vwb..i1-tbastu3l-024pa-efsp",
                "lang": "ne",
                "hasPaywall": false
            },
            {
                "datetime": 1645463052717,
                "headline": "tp iinca aTirmaaanp A nghsr edlr n- wAzai smy olngzhio  fnolC",
                "source": "S adAyoTU",
                "url": "enc3sct-s//xd33-t-/beu6di46.:csaccdthpadv3do26a91p2.19ab/l6il3w2-28/eerei1/m1o",
                "summary": "Cnl la 1 iAeoaAuiudstswnl  nkeroet uye sdnsasalnppa, hfii eeppbn sta icy -z 2sl.  eothdmclta-roorolco srmtejr  ucac-t",
                "related": "AMZN",
                "image": "48h./1d/-132g6d2i/upeowsxb-6ebvcaem/ec3n1pm199lde26d3sit-/aa3.3/t-i:s2dcoca6",
                "lang": "ne",
                "hasPaywall": false
            },
            {
                "datetime": 1632437506297,
                "headline": "eureSees erba 2C iotestnrdYgsna l ssCeoeLt lA0",
                "source": "iagznBne",
                "url": "r7asveut/s/d40t9choe8i-icli6/80x/-6o-7ceac6.11//w1sb0be-c37atbpnca2c.7clfmpa:1",
                "summary": "Cehdt  tiy msnios6teTnn iLnuv idehpuh9Fsoamra(s  t s siet  cSi lt  enaelboneunedteo/Cs vOew ea enottrfr hyghu pnhn n opoyiid onaoik wn esaatsmr0c tafanor i rniueiied yvleeftrlghoenuterlcn  rs epssnttyst ,tonhRbn ppeie-pntrLeoaesea ic sdnhye umiaotvt vgr i.sefsgn/  ieerhc0tC0eeidsAegkont fm eHAiFvfztdsn oioe tmps  utlteqAnoAt eelgg ihEgrreeaotiSanbe e osidinstcc i trEAuAeBds eovp ay ri Aeel Lusdws asrrr, gunee euovcssgechuor so,ee , eegnLtgle  l5daeseno tnnolrtpee dl nssveecr  n n   i.nlr.ntewehaeont ale iy yndasecetoanodum  dwbmc)st sptc te osa  u trft,t,meltnh lSdkddi rgoeoee\'s ctpo  cgoeofasoc2 0h2etdios escg  oio  Lebhap.dct fnnr ooesr b   djDoc n4a   lataivt  ,sihwl.m aaiO-sn  a wbeoegard0tl foali-nhi0Od i ertfe4mesnec t enr   cefdtfeneaTnd nmgf nrnimas,sAmlnay tpis suNl rtgeiftiitodfupepfysethdsgSi.eSrahocdPkne, ms iscdhniPre ttd pg mo-m01b a  e rteOnteothoriN o euiaccrrtlsaiaf 2n,x h g\'r anee imrLc  e -A. noepaGnue eelowmdm isenp eOl  moinLs nxeimgmmkos in aNrdantr ,brepdh el tneohe th ",
                "related": "NZAM",
                "image": "-af/0110:c1s3d/m7.x7aigoipc6cv0w6o/nse-ea4cpc/-i/98cae6.2l/b78b7uhettcma-1sb",
                "lang": "en",
                "hasPaywall": false
            },
            {
                "datetime": 1580294886532,
                "headline": "onR ot Tlt  akdcu yedznng  oonplaFea e ycVBm  ihoATeonneooAmorie uD CM|l",
                "source": "oey oeltMolF Th",
                "url": "b8l4cei1f4pr8bvhst0c4-2ix-ab8bc5slo/en/.t9es/3ic8/8u4-d-md/4ccp1aa5t01o942w/:.",
                "summary": "auonihnehoenseet heneprchnlw rtseuhtf o osasTsf gria ymtts rsl  f  tth  bris eaiaro gdrn a moibpittm fatiasdgshastr  ta.aldes ",
                "related": "ANZM",
                "image": "/.cb/euc/bce81es42-/d51lpafc1h-i:bm/0vixg.0ca24npm3it9s4ot84/w8-8b4o985as-d4",
                "lang": "ne",
                "hasPaywall": false
            }
        ],
        "quote": {
            "symbol": "AMZN",
            "companyName": "Amazon.com, Inc.",
            "primaryExchange": "QDNAAS",
            "calculationPrice": "close",
            "open": 1794.34,
            "openTime": 1600182751456,
            "close": 1775.25,
            "closeTime": 1637588035538,
            "high": 1781.009,
            "low": 1742.97,
            "latestPrice": 1822.15,
            "latestSource": "Close",
            "latestTime": "October 4, 2019",
            "latestUpdate": 1645630889686,
            "latestVolume": 2580940,
            "iexRealtimePrice": 1812.17,
            "iexRealtimeSize": 51,
            "iexLastUpdated": 1611830285839,
            "delayedPrice": 1747.07,
            "delayedPriceTime": 1629647621871,
            "extendedPrice": 1764.5,
            "extendedChange": 5.82,
            "extendedChangePercent": 0.00339,
            "extendedPriceTime": 1613282341636,
            "previousClose": 1738.48,
            "previousVolume": 3733906,
            "change": 15.53,
            "changePercent": 0.00892,
            "volume": 2564871,
            "iexMarketPercent": 0.01387744396670574,
            "iexVolume": 34947,
            "avgTotalVolume": 3216018,
            "iexBidPrice": 0,
            "iexBidSize": 0,
            "iexAskPrice": 0,
            "iexAskSize": 0,
            "marketCap": 879459099737,
            "peRatio": 72.77,
            "week52High": 2038.6,
            "week52Low": 1315,
            "ytdChange": 0.14522,
            "lastTradeTime": 1617873872922,
            "isUSMarketOpen": false
        }
    }
}');

        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $this->iexApi = new \Digitonic\IexCloudSdk\Client($client);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $batch = new \Digitonic\IexCloudSdk\Stocks\Batch($this->iexApi);

        $this->expectException(WrongData::class);

        $batch->get();
    }

    /** @test */
    public function it_should_fail_without_a_type()
    {
        $batch = new \Digitonic\IexCloudSdk\Stocks\Batch($this->iexApi);

        $this->expectException(WrongData::class);

        $batch->setSymbols('aapl', 'amzn')->send();
    }

    /** @test */
    public function it_can_query_a_single_market()
    {
        $batch = new \Digitonic\IexCloudSdk\Stocks\Batch($this->iexApi);

        $batch->setSymbols('aapl')
            ->setTypes('quote', 'news')
            ->get();

        $this->assertContains('stock/aapl/batch', $batch->getFullEndpoint());
    }

    /** @test */
    public function it_can_query_a_range_with_chart()
    {
        $batch = new \Digitonic\IexCloudSdk\Stocks\Batch($this->iexApi);

        $batch->setSymbols('aapl')
            ->setTypes('quote', 'news', 'chart')
            ->setRange('1m')
            ->get();

        $this->assertContains('chart&range=1m', $batch->getFullEndpoint());
    }

    /** @test */
    public function it_can_not_query_a_range_with_out_chart()
    {
        $batch = new \Digitonic\IexCloudSdk\Stocks\Batch($this->iexApi);

        $batch->setSymbols('aapl')
            ->setTypes('quote', 'news')
            ->setRange('1m')
            ->get();

        $this->assertNotContains('chart&range=1m', $batch->getFullEndpoint());
    }

    /** @test */
    public function it_can_query_a_multiple_markets_and_types()
    {
        $batch = new \Digitonic\IexCloudSdk\Stocks\Batch($this->iexApi);

        $response = $batch->setSymbols('aapl', 'amaz')
            ->setTypes('quote', 'news')
            ->get();

        $this->assertContains('stock/market/batch', $batch->getFullEndpoint());
        $this->assertContains('types=quote%2Cnews', $batch->getFullEndpoint());
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);

        $response = $response->toArray();
        $this->assertEquals("a'sBornr", $response['AAPL']->news[0]->source);
        $this->assertEquals(true, $response['AAPL']->news[0]->hasPaywall);
        $this->assertEquals('ALAP', $response['AAPL']->news[0]->related);

        $this->assertEquals("AAPL", $response['AAPL']->quote->symbol);
        $this->assertEquals("Apple, Inc.", $response['AAPL']->quote->companyName);
        $this->assertEquals("close", $response['AAPL']->quote->calculationPrice);
        $this->assertEquals(225.89, $response['AAPL']->quote->open);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Batch::shouldReceive('setSymbols')
            ->once()
            ->andReturnSelf();

        Batch::setSymbols('aapl');
    }
}
