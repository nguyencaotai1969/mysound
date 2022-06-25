<?php

if ( !defined("root" ) ) die;

class og_coinpayments {

	public $mode = "sandbox";
	public $public_key = null;
	public $private_key = null;
	public $ipn_secret = null;
	public $merchant_id = null;
	public $currency = null;
	public $client = null;
	public $currencies = [
		 "BTC","BTC.BEP2","BTC.BEP20","BTC.LN","USD","BCH","BCH.BEP2","BCH.BEP20","LTC","LTC.BEP2","LTC.BEP20","VLX","VLX.Native","CAD","EUR","KYD","0RT","0xBUTT","0xESV","0xETD","0xETH2","0xGang","18T","1bit","1GOLD","1UP","1WO","3DB","5KM",777,"7E","8BT","9TK","A","A2A","AAA","AB","ABB","ABC","ABCS","ABE","ABL","ABTN","ACE","ACTP","ACTX","ADA.BEP2","ADA.BEP20","ADB","ADC1","ADI","ADP","ADS","ADSVC","ADVC","AE","AED","AEDex","AEG","AENS","AET","AET2","AFC","AFDLT","AfroX","AFTK","Agem","AGI","AGN","AGRI","AGRI2","AGT","AGX","AI","AiBe","AIC","AIC2","AID","AIDOC","AIGC","AIGO","AIRx","AIT","AKA","AKYE","AKYU","ALB","ALC","ALF","ALGOR","ALI","ALP","ALPHA","ALTX","ALX","AMA","AMB","AMBA","AMBT","AMIS","AMN","AMON","AMPL","AMR","AMSC","AMT","ANGEL","ANON","ANON2","AOA","APIS","APL","APM","APO","APOD","APPC","APPU","APX","AQU","AR2","ARAW","ARB","ARBIT","ARC","ARCG","ARCONA","ARGC","ARGP","ARM","ARN","ARP","ARPA","ARS","artTAC","ASK","ASK2","ASM","AT","ATK","ATL","ATMI","ATOC","ATOM","Atp","AUD","AUPC","AUSC","AVEX","AVINOC","AVT","AVT2","AVVP","AWC","AWE","AXEL","AXPR","AXTR","AYA","AZ","AZN","B21","B2BX","B2C","B2X","BAAS","BAC","BAD","BANG","banTAC","BAR","BARG","BART","BASE","BAT","BAZT","BAZT2","BBC","BBC2","BBI","BBK","BBK2","BBR","BBTC","BC","BC2","BCASH","BCD2","BCDT","BCMC1","BCMG","BCN","BCO","BCP","BCP2","BCPT","BCT","BCV","BCZ","BDCC","BDG","BDOT","BEAM","BEAT","BEAUTY","BEAUTY2","BEC","BEC7","BECX","BEE","BEENG","BEG","BELA","BER","BERM","BETHER","BETRA","BETRA2","Bez","BFB","BFDT","BFT","BGENE","BGF","BGN","BGR","BHIG","BHPC","BIB","BIC","BIGO","BIL","BIM","BIN","BIO","BIRC","BIT","BITCAR","BITE","BITOX","BITRON","BITTO","BITTO.Old","BITX","BITX2","BIZ","BIZZ","BK","BK2","BKC","BKS","BKX","BKY","BLB","BLISS","BLK2","BLZ","BM","BMAX","BMC","BMEX","BMT","BNB","BNB.BSC","BNB.ERC20","BNEX","BNFT","BNI","BNI.Old","BNI.Old2","BNK","BNOW","BNT","BNT2","BNX","BNX2","BNX3","BOB","BOC","BOLD","BOOTY","BOR","BOR2","BOS","BOTA","BOUNCY","BOUNCY2","BOX","BPT","BPT2","BPTN","BPTT","BQQQ","BQQQ2","BQTX","BRD","BRDC","BRL","BRM","BRT","BRZC","BSC","BSD2","BSR","BSTN","BSV","BTAP.BEP20","BTAP.ERC20","BTB","BTCA","BTCB","BTCBAM","BTCC","BTCG","BTCGW","BTCM","BTCM2","BTCONE","BTCPLO","BTCR","BTCS","BTCS2","BTCV","BTCX","BTD","BTG","BTG2","BTH","BTK","BTL","BTL2","BTL3","BTM","BTM2","BTMC","BTN","BTN2","BTNT","BTO","BTR","BTRS","BTSG","BTT","BTT.BEP2","BTTC","btz","BTZ2","BUBO","BUL","BUL2","BUNNY","BUSD","BUSD.BEP2","BUSD.BEP20","BUT","BVSN","BWX","BXA","BXK","BYCC","BYN","BYTM","BZET","BZX","C4F","C8","CAF","CAIZ","CAMS","CAN","CANDY","CANX","CAO","CAPC","CAPP","CAPP2","CAS","CAST","CAV","CB","CBIT","CBIX","CBN","CBP","CBR","CBS","CBT","CBT2","CBT3","CBTB","CBUCKS","CC","CCC","CCC2","CCC3","CCCoin","CCH","CCHN","CCIO","CCL","CCN","ccnext","CCOG","CCOS","CCRB","CCS","CCT","cDAI","CDC","CDC2","CDRX","CDT","CEEK","CEL","CELC","CELO","CELR","CELR2","CEN","CEN2","CENNZ","Centra","CF","CFI","CGC","CGC2","CGCX","CGW","CHART","CHC","Che","CHF","CHG","CHP","CHR","CHR2","CHR3","CHSB","CHZ","CIM","CIPX","CIT","CITY","CJT","CK","CKEY","CLB","CLC","CLEAR","CLIN","CLM","CLN","CLO","CLOAK","CLOG","CLOUT","CLP","CLR","CM","CMA","CMA2","CMN","CMT","CNB","CNC","CND","CNG","CNMC","CNN","CNNS","CNX","CNY","CoCo","COFI","COI","COI2","COL2","COM","COMP","CONS121","COP","CORES","COREX","COSM","COSM2","COTI","COTI2","COU","COVA","CP","CPAY","CPC","CPF","CPG","CPIT","CPL","CPOL","CPR","CPROP","CPT","CPTL","CPX","CRAFTR","CRB","CRC","CRD","CRD2","CRE","CREDIT","CREDO","CREO","CRET","CREV","CRO","CRO2","CROS","CRPT","CRT","CRW","CRX","CRYO","CRYSTAL","CS","CSAT","CSC","CSM","CSMX","CSR","CTAT","CTH","CTK","CTO","CTX","CTXC","CUAN","CUB","CUC","CURE","cUSD","cUSDC","cV","CVA","CVM","CVP","CVT","CWN","CWV","CYFM","CYL","CZK","DAAR","DAC","DACC","DAF","DAG","DAG2","DAI","DAI.BEP20","DAI2","DAN","DANK","DANS","DAP2","DAPP","DAPP2","DAPPT","DAR","DAR2","DARK","DASH","DAT","DATBOI","DATG","DATP","DATx","DAV","DAX","DBM","DCA","DCA.Old","DCAS","DCAST","DCC","DCHS","DCNX","DCORP","DCS","DCS2","DCTO","dDai","DEAL","DEED","DeerEx","DEFL","DELTA","DEN","DENT","DFR","DFS","DFS2","DGB","DGC2","DGPT","DGTX","DGTX2","DHT","DIA","DIC","DIFX","DIGT","DiGTC","DIMND","DITC","DITC3","DIVI","DIW","DKK","DLT","DMND","DMT","DMTS","DNC","DNET","DNET2","DNL","DNT","DNT2","DOCK","DOG","DOGE","DOGE.BEP2","DOGE.BEP20","DOGEX","DOGEX2","DOPT","DOR","DOS","DOT.BEP2","DOT.BEP20","DPN","DPSC","DPST","DPT","DRCT","DREAM","DRG","DRGN","Drink","DRN","DRONE","DROP","DSCB","DSN","DSPX","DSQ","DST","DT","DTA","DTC","DTK","DTRC","DUCAT","DUSK","DWS","DXCASH","DXG","DYT","E2C","EAI","EAR","EAT","EBC","eBCC","EBK","EBNB","EBST","EBTC","EBYTE","EC","ECASH","ECHG","ECO","ECO2","ECO3","ECOM","ECOMT","ECP","ECPN","ECT","EDOGE","EDT","EDU","EEE","EER","EES","EET","EFFM","EFI","EGC","EGC2","EGG","EGT","EGT2","EKT","EKT2","ELEC","ELI","ELT","ELTC","ELTX","ELV","ELYTE","EMAN","Emoji","EMONA","EMONT","EMPR","EMPRB","EMT","ENAU","ENC","ENCX","ENG","ENJ","ENK","ENTRY","ENTS","ENU","EO","EON","EON2","EOSBNT","EOSC","eosDAC","EOSG","EOST","EOST2","EOT","EPAY","EPC","EPCO","EPH","EPL","EPLAYG","ePRX","EPY","EQL","ERC20","ERCMO","ERK","ESAX","ESHIP","ESS","ET","ETC","ETCR","ETD","ETD2","ETG","ETGP","ETH","ETH.BEP2","ETH.BEP20","ETH3","ETHAI","ETHB","ETHBNT","ETHC","ETHC2","ETHC3","ETHER","ETHMNY","ETHPLO","ETHS","ETHUC","ETHV","ETHV2","ETM","ETN","ETOS","ETR","ETS","ETU","ETWT","ETY","EUCX","EURB","EURS","EURT","EVA","EVC","EVEO","EVN","EVN2","EVY","EXAC","EXC","EXMR","EXNX","EXPO","EXTRA","EYC","F2K","FABA","FACC","FACE","FACTS","FAIR","FANZ","FBC","FBN","FBTC","FCC","FDZ","FET","FET2","FEX","FEY","FF","FFF","FGP","FilmC","FIRO","FISH","FIT","FKX","FLASH","FLETA","FLIX","FLOT","FLP","FLT2","FLX","FLX2","FLY","FND","FNKOS","FNKOS2","FNTC","FOOD","FOR","FORTH","FOTA","FOX","FOXT","FPT","FREC","FRES","FRIKANDEL","FT","FT1","FTEC","FTI","FTM","FTM.BEP2","FTXT","FUD","FUEL","FUN","FUND","FUNDZ","FUZE","FXBK","FXC","FXET","FXP","FXT","FXY","FYS","G","G4B","G4D","g9tro","GAE","GANA","GARD","GAZPROM","GBC","GBK","GBP","GBP2","GBT","GBT2","GBX","GC","GCASH","GCB","GCB2","GCC3D","GCG","GCG.Old","GCG.Old2","GCS","GCU","GDE","GDP","GDPR","GEF","GEL","GELDC","GEM","GENE","GENT","GES","GET","GETX","GEX","GFL","GFN","GFT","GFUN","GG","GGL","GHS","GHX","gif","GIFT","GIP","GLARB","GLO","GLX","GLX2","GMB","GMET","GMV","GNC","GNCT","GNT","GNX","GOB","GOD","GODZ","GOEX","GOLD","GOLD2","GOLD3","Googol","GOOLA","GOT","GOT2","GoTJS","GPaid","GPaid2","GPN","GPT","GR","GR2","GRAM","GRS","GRT","GRX","GSC","GSE","GSGC","GST","GTO","GTX","GUAP","GUNTHY","GUP","GUSD","GVE","GVINE","GVT","GWT","GXC","HAE","HAND","HART","HAV","HBZ","HC","Hcoin","HDA","HDC","HEC","HEC2","HELP","HER","HERB","HERO","HETA","HEX","HEX2T","HGO","HGT","HIBT","HINT","HIT","HKD","HKDex","HKY","HLI","HLOS","HLS","HMB","HMC","HOT","HOT2","HOTC","HOUSE","HPC","HPS","HQX","HRK","HRT","HSB","HSC","HSHC","HT","HTX","HTX2","HUF","HUP","HUR","HUSD","HVC","HVE","HXRO","HXY","HYBN","HYDRO","HYDRO2","HYPE","i","I9C","IAG","IBA","IBA2","IBTC","IBTC2","iCash","ICC","iCSH","ICST","ICTA","IDH","IDK","IDN","IDR","IDRT","IDXE","ieos","IEX","IEXC20","iFish","IFOOD","IFT","IG","IGNT","IGTMYR","IHT","IIC","ILC","ILS","ILT","IMC","IMDX","IMOS","IMP","IMT","IMVR","IND","INEX","INGAME","INGRAM","INK","INN","INNBC","INNBCL","INR","INRex","INS","INS2","INSTAR","INSUR","INT","INVITE","INVOX","IONC","IOST","IOT5","IOTA.BEP20","IOUX","IOV","IPSX","IPUX","IRR","IRT","IRX","ISK","IST","ITC","ITCB","IUT","IVO","IVY","IWC","IZER","IZER2","IZI","IZX","J8T","JAR","JBX","JC","JDT","JE","JEX","JOB","JPY","JSE","JURM","KBC","KBC2","KCH","KCS","KCS.Old","KEA","KEOS","KES","KEY","KEYS","KGT","KGW","KHC","KHP","KICK.Old","KINBNT","KIND","KIT","KITTEN","KLT","KMD","KMX","KNC","KNDC","KNO","KNOW","KNT","KPNG","KPR","KRC","KRC2","KREX","KRI","KRL","KRS","KRW","KRYP","KSC","KSG","KSS","KTC","KTD","KTT","KUE","KUR","KWATT","KYO","LAK","LAKE","LAMB","LAMBO","LAMBO2","LAToken","LATX","LBA","LBA2","LBOT","LC","LCD","LCK","LDC","LDN","LEEK","LEF","LEND","LEON","LET","LEXC","LEXT","LFT","LGBTQ","LGR","LGUM","LHC","Libfx","Libfx2","LIFE","LINK","LINK.BEP20","LINO","LION","LIPS","LIQUID","LK","LKSC","LMDA","LNC","LOC","LOOIX","LOOIX2","LOT","LOTO","LOVC","LPC","LPT","LRC","LSK","LST","LT","LTB","LTC.Waves","LTC2","LTCD","LTCP","LTK","LTN","LUC","LXT","LYKK","LYNDA","LYQD","LYS","M10","MAC","magTAC","MAID","MANA","MAPR","MASP","MATIC","MATIC.BEP20","MAYA","MB","MBCH","MBN","MBTC","MBYZ","MCAP","MCASH","MCC","McFLY","MCG","MCO","MDCM","MDK","MDM","MDR","MDTK","MEDA","MEDAL","MEDIBIT","MEDS","MEME","MEQ","MEREX","MESH","MET","METH","mETH2","METM","MFT","MGC","MIB","MIC","MILE","MILO","MINAX","MINDS","MINEX","MINX","MIO","MIT","MITx","MK","MKC","MKCN","MKD","MKF","MKR","MMT","MNE2","MNE3","MOAS","MOAT","MOC","MOLK","MOLK2","MOR","MOR2","MORE","MORPH","MOT","Mpax","MPAX2","MPU","MPX","MRG","MRK","MRL","MRN","MRO","MRP","MRS","MRS2","MSB","MSB2","MSC","MSD","MSG","MSH","MSIA","MST","MST2","MT","MTC","MTCX2","MTH","MUNE","MUR","MUSE","MUSK","MUST","MVG","MVL","MVP","MVR","MWAVS","MXM","MXM2","MXN","MXNT","MYBET","MyDFS","MYEX","MYOU","MYR","MYT","MZG","NACRE","NAM","NAMTT","NANJ","NANOCOIN","NAT","NAVI","NAVI2","NBAT","NBC","NBT2","NBT3","NC","nCash","NCL","NDX","NEAL","NEE","NEEO","NEO","NEOD","NEON","NESC","NEWOS","NEXO","NEYROS","NFC","NGC","NGN","NGOT","NICASH","NIRX","NKN","NLC","NLC3","NLS","NMP","NMR","NMX","NN","NOAH","NOAHP","NOBS","NOK","NOMO","NOVI","NOW","NOX","NPLAYG","NPT","NPXC","NPXS","NQN","NRM","NRN","NRP","NST","Nsure","NTC","NTICP","NTK","NTK2","NTN","NTOK","NTWK","NTX","NUG","NULS","NULS.BEP20","NUMEX","NVT","NYBC","NZD","O2O","OAK","OAP","OAS","OAX","OBX","OBXP","OCC","OCN","OCT","OD","ODC","ODEM","ODMC","OGOD","OHNI","Ohni2","OHTANI","OICOIN","OKB","OKM","OKO","OLE","OMG","OMNES","OMNI","OMX","ONE","ONG","ONP","OnUp","OPCT","OPEN","OPENC","OPET","OPET2","OPQ","OPS","OPT","OPTC","ORIC","ORME","ORO","OSC","OSCH","OSHI","OTB","OTN","OUT","outTAC","OVF","OVO","OWC","OWD","OWL","OXEN","OXI","OXT","OXY","P2PG","PAI","PAID","PAL","PAR","PAT","PAX","PAX2","PAY","PAYA","PAYA2","PAYIN","PBTT","PCT","PDC","PEF","PEN","PERL","PERU","PETRO","PEW","PEX","PGC","PGC2","PHI","PHM","PHN","PHNX","Phone","PHP","PHPex","PHRM","PHT","PHX","PIB","PICKLE","PIGGY","PIT","PIVX","PIX","PKG","PKR","PLA","PLA2","PLAAS","PLAT","PLC","PLN","PLS","PLU","PLUS","PM7","PMA","PMC","PMNT","PMUP","PNK","PNT","POA20","POABNT","POK","POLY","PONA","PONAIR","POPCOIN","POSS","POT2","POTA","POTE","POWR","PPD","PPDX","PPP","PPS","PPT","PPTK","PRE","PRE2","PRF","PRIX","PRL","PRN","PRO","PROC","PROD","PRSMD","PT2","PTK","PTNX","PTT","PTYS","PUN","PUNDIX","PVT","PWV","PXC","PXE","PXG","PXLT","PXP","PXP2","PYN","PYX","QASH","QAU","QBE","Qbs","QBT","QDA","QDT","QPAY","QRP","QSP","QTF","QTUM","QUIN","QWARK","R","radTAC","RAKU","RALLY","RAM","RAMEN","RAYAX","RBDN","RBLX","RBTC","RBTC2","RBX","RCN","RDN","RDX","REBL","REBLC","REDRA","REDV","REF","REG","REKT","REOS","REP","REQ","RES","REX","RFE","RFR","RFX","RGB","RGLS","RGT","RIC","RIDE","RIDE2","RIG","RIPT","RIS","RISK","RKT","RNT","RNTB","ROBO","ROC","ROCK","ROCK2","Rock2Pay","ROK","RON","ROTA","ROTA2","RPCN1","RTB","RTGS","RTH2","RUB","RUSH","RVN","RWF","RXE","RXL","RYD","S","S3C","SAC","SAFEBTC.BEP20","SAFU","SAI","SALT","SAM","SANC","SAT","SATAN","SATO","SATT","SATX","SAVE","SBA","SBC","sBTC","SCB","SCC","SCC2","SCCTN","SCD","SCH","SCT","SCT2","SCX","SDA","SDC","SDFT","SEC","SEC2","SEER","SEHR","SEK","SENX","SERENITY","SETH","SETI","SETI2","SEXC","SEYU","SFP.BEP20","SFU","SG","SGC","SGCC","SGD","SGDex","SGN","SGP","SHAG","SHEEP","SHEL","SHIP","SHIT","SHL","SHOP","SHPC","SHPING","SHR","SIG","SIM","SINGH","SKE","SKI","SKIN","SKL","SKRP","SKYFT","SKYM","SLD","SLK","SLRM","SLT","SLV","SMART","SMART2","SMG","SMT","SMT2","SMT3","SNBL","SNcoin","SNGX","SNT","SNT2","SNTR","SNTVT","Soar","socTAC","SOL","SOL2","SOP","SOUL","SOUND","Soundeon","SOV","SPARC","SPAZ","SPAZ.Old","SPB","SPD","SPECT","SPH","SPH2","SPIZ","SPON","SPS","SPS2","SPX","SPZ","SPZ.Old","SQR","SRK.BEP20","SRK.ERC20","SRN","SRNT","SRX","SSP","STAC","STAMP","STASH","STASH2","STATIZ","STCDR","STDEX","STE","STER","STH","stish","STM","STM.Old","STMX","STMX2","STO","STORJ","STORM","STPZ","STQ","STR2","STS","STT","STY","SUN","SUPR","SURE","SURE2","SUSHI","SW","SWAMP.BEP20","SWC","SWFTC","SXE","SXL","SXS","SYS","SZC","T8T","TAB","TAC","TAI","TAL","TAPS","TAS","TAXC","TB","TBCoin","TBFC","TBL","TBT","TBT2","TBTC","TBTC.Tidbit","TCA","TCASH","TCAT","TCH","TCL","TCR","TCT","TDH","TDP","TEAM","TEL","TEL.Old","TELE","TEP","TERI","TERN","TET","teTAC","TEU","TEUR","TFD","TGC","TGCO","TGT","THB","THL","THL2","THM","THR","THRN","THUG","THX","TIDAL","TIKTOK","TILY","TIO","TIP","TIR","TIS","TIX","TKA","TKLN","TKN","TKT","TLC","TLC2","TLW","TMB","TMC","TND","TNT","TOE","TOKO","TOMA","TONE","TOPB","TOPBTC","TOPG","TOS","TOS2","TOTO","TOU","TPAY","TQN","TRA","TRADE","TRAK","TRAT","TRAVEL","TRF","TRG","TRIM","TRIO","TRIX","TRIX.TrixChain","TRM","TRM2","TRON","TRP","TRST","TruAu","TRV","TRX","TRX.BEP2","TRX.ERC20","TRXC","TRY","TSHP","TTC","TTC2","TTKN","TTT","TTV","TUSD","TUSD.BEP20","TUSD2","TVT","TVT2","tvTAC","TWC","TWD","TWNKL","TWT","TWT.BEP20","TXC","TXT","TXT2","TXT3","TXTE","TXY","TYPE","UAH","UBC","UBEX","UBIT","UBN","UC","UCA","UCASH","UCN","UCT","UEC","UFAN8","UGC","UIP","UKG","UKR","ULLU","ULT","ULTRA","UMA","UMT","UNB","UNC","UNI","UNI.BEP20","UNI2","UNIA","UNIT","UNIT2","UNV","UOK","UOS","UPBTC","UPP","UPUSD","UPXAU","UQn","URUN","USAT","USD1","USD2","USDC","USDC.BEP20","USDex","USDN","USDS","USDS2","USDT","USDT.BEP2","USDT.BEP20","USDT.ERC20","USDT.Waves","USDX","USE","USEC","UST","UST.BEP20","UST2","UTK","UTK.Old","UTNP","UTO","UUNIO","VALOR","VALUE","VALUE2","VB","Vcash","VCCN","VCT","VD","VDH","VEN","VERS","VES","VEST","VETH","VFA","VGB","VGS","VIB","VIBE","VICO","VIDB","vidTAC","VIDY","VIEW","VIN","VINX","VIO","VIP","VIRIDI","VIU","VIX","VLC","VLTR","VME","vmTAC","VND","VNDC","VNDex","VNM","VNS","VPP","VQR","VRA","VRS","VRT","VS","VSO","VST","VT","VT2","VTA","VTC","VTCH","VTR","VTY","VVC","VVI","VXD","VXNT","VXRC","VYA","W0xETH","W12","W2TW","W3C","WAB","WAR","WAVES","WBNB.BEP20","WBT","WCC","WDT","WEB","WEBN","WEL","WELL","WETH","WFEE","WGC","WGT","WIKEN","WIN","WIN2","WIN3","WIT","WITH","WKC","WLM","WMCH","WMK","WNK","WNS","WOLF","WOM","WOM.Old","WOO","WOOL","Woonk","WOT","WOZX","WPR","WRC","WS","WSE","WSS","WT","WTC","WTE","WTL","WTP","WTS","WUSD","WZI","XAG","XAP","XAU","XAUR","XBANC","XBP","XBR","XCEL","XCLR","XCON","XCT","XCUR","XCZ","XDAC","XDMC","XEM","XEMX","XEN","XFRC","XGM","XI","XIN","XLAB","XLC","XLMC","XLMG","XLMGOLD","XLMX","XMC","XMCT","XMD","XMOO","XMR","XMRG","XMX","XNK","XNN","XOF","XPR","XPR2","XPS","XPT","XPU","XRA","XRB","XRM","XRP","XRP.BEP2","XRP.BEP20","XRPC","XRR","XRT","XRT2","XSAP","XSN","XSP","XT","Xtera","XTRLPay","XTX","XVG","XVT","XYO","YAH","YANU","YAP","YD","YEE","YES","YESM","YFI","YFIM","YOO","YSN","YUSDT","YZC","ZAG","ZAR","ZB","ZBK","ZBK2","ZCN","ZDR","ZDR2","ZEC","ZEEW","ZEN","ZERO","ZEWT","ZFL","ZIG","ZIL","ZING","ZIP","ZJLT","ZKS","ZLA","ZNT","ZOM","ZPR","ZRX","ZSC","ZTX","ZXC","ZYN","CSC.Old","CR8","BTC.Bitstamp","CAD.Bluzelle","EUR.Bitstamp","GBP.Bitstamp","USD.Bitstamp","LTCT"
	 ];

	public function __construct( $pay ){

		$this->pay = $pay;
		$this->loader = $pay->loader;
		$this->db = $this->loader->db;

	}
	public function getClient(){

		if ( !$this->loader->admin->get_setting( "pg_cp" ) ) return false;
		if ( !( $this->public_key  = $this->loader->admin->get_setting( "pg_cp_k1" ) ) ) return false;
		if ( !( $this->private_key = $this->loader->admin->get_setting( "pg_cp_k2" ) ) ) return false;
		if ( !( $this->ipn_secret  = $this->loader->admin->get_setting( "pg_cp_k3" ) ) ) return false;
		if ( !( $this->merchant_id = $this->loader->admin->get_setting( "pg_cp_k4" ) ) ) return false;
		if ( !( $this->currency    = $this->loader->admin->get_setting( "pg_cp_cr" ) ) ) return false;
		if ( !empty( $this->client ) ) return $this->client;

		require_once( app_core_root . "/third/coinpayments-php/vendor/autoload.php" );

		$this->client = new CoinpaymentsAPI( $this->private_key, $this->public_key, 'json');
		return $this->client;

	}
	public function getCurrencies(){
		$_cs = [];
		foreach( $this->currencies as $_c ){
			$_cs[ $_c ] = $_c;
		}
		return $_cs;
	}

	public function get_link( $charge_amount, $order_no ){

		$client = $this->getClient();
		if ( !$client ) return false;

		try {
			$transaction_response = $client->CreateCustomTransaction( array(
				"amount"      => $charge_amount,
				"currency1"   => $this->loader->admin->get_setting( "currency_code" ),
				"currency2"   => $this->currency,
				"buyer_email" => $this->loader->visitor->user()->email,
				"success_url" => web_addr . "user_pay_result?og=coinpayments&on={$order_no}",
				"cancel_url"  => web_addr . "user_pay_result?og=coinpayments&on={$order_no}",
				"ipn_url"     => web_addr . "user_pay_result?og=coinpayments&on={$order_no}",
				"invoice"     => $order_no
			) );
		} catch (Exception $e) {
			return array(
				"sta"  => false,
				"data" => $e->getMessage()
			);
		}

		if ( !empty( $transaction_response["error"] ) ? $transaction_response["error"] != "ok" : false ){
			return array(
				"sta"  => false,
				"data" => $transaction_response["error"]
			);
		}

		return array(
			"sta"  => true,
			"data" => $transaction_response["result"]["checkout_url"],
			"txn"  => $transaction_response["result"]["txn_id"],
			"extraData" => [ "coin_amount" => $transaction_response["result"]["amount"]  ]
		);

	}
	public function get_txn_id( $receipt ){

		return $receipt["data_txn_id"];

	}
	public function check_result( $receipt ){

		$client = $this->getClient();
		if ( !$client ) return false;

		$verify = $client->GetTxInfoMulti( $receipt["data_txn_id"] );
		if ( !$verify ) return false;

		$verify_receipt = $verify["result"][$receipt["data_txn_id"]];

		if ( empty( $verify_receipt["error"] ) ? true : $verify_receipt["error"] != "ok" )
		return false;

		if ( $verify_receipt["coin"] != $this->currency )
		return false;

		if ( $receipt["data"]["coin_amount"] > $verify_receipt["receivedf"] )
		return false;

		if ( $verify_receipt["status"] != 100 && $verify_receipt["status"] != 2 )
		return false;

		return true;

	}

}

?>
