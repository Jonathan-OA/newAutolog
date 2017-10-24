SELECT 
							c.PRDCAD_CODIGO,
		                    COUNT(DISTINCT u.UMVCAD_ID),
							CASE WHEN c.UOMCAD_CODPRI <> 'M2' THEN SUM(c.INVAPO_QDE) ELSE SUM(u.UMVCAD_LARGURA * c.INVAPO_QDE) END as QDE,
							c.UOMCAD_CODPRI
							from 
							invapo c
					INNER JOIN umvcad u on (c.UMVCAD_ID = u.UMVCAD_ID)
					INNER join prdcad p on (u.UMVCAD_PRDCAD = p.PRDCAD_CODIGO and p.EMPRES_CODIGO = ".$_SESSION['Pempresa']." and p.FILIAL_CODIGO = ".$_SESSION['Pfilial'].")
					INNER JOIN prdemb e on (p.EMPRES_CODIGO = e.EMPRES_CODIGO and p.FILIAL_CODIGO = e.FILIAL_CODIGO and p.PRDCAD_CODIGO = e.PRDCAD_CODIGO and e.PRDEMB_NIVEL = 1)
					LEFT JOIN tarefa t on (c.TAREFA_SEQ = t.TAREFA_SEQ AND
										   t.TAREFA_STATUS = 8 AND
										   t.TAREFA_DOCCABSEQ = ".$_REQUEST['doccab_seq'].")
					WHERE (c.DOCCAB_SEQ = ".$_REQUEST['doccab_seq']." OR
						   t.TAREFA_SEQ IS NOT NULL)	AND
						  c.TRANS_CODIGO IN ('745','771') AND
						  c.INVAPO_STATUS < 9
					GROUP BY c.PRDCAD_CODIGO, c.UOMCAD_CODPRI, c.TRANS_CODIGO