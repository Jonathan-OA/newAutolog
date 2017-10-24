select umvcad.umvcad_id 
from umvcad 
inner join doccab OS on (os.DOCCAB_SEQ = umvcad.UMVCAD_DOCCABSEQ and 
                         os.DOCTIP_CODIGO = 'RCO' and
                         os.doccab_status in (7,8))
inner join saldo on (saldo.UMVCAD_ID = umvcad.UMVCAD_ID and 
                     saldo.SALDO_FINALIDADE = 'Saldo')
inner join doccab PVD on (PVD.DOCCAB_NUMERO = OS.DOCCAB_DOC_ORIGEM and  
                          PVD.DOCCAB_STATUS not in (0,9,2))
where umvcad.UMVCAD_TOCO = 1


--Cancelar etiquetas

--update umvcad set umvcad_status = '9' where umvcad_in in ( query acima )