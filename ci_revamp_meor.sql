--
-- PostgreSQL database dump
--

-- Dumped from database version 14.2
-- Dumped by pg_dump version 14.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: dbms_lock; Type: SCHEMA; Schema: -; Owner: rookiextreme
--

CREATE SCHEMA dbms_lock;


ALTER SCHEMA dbms_lock OWNER TO rookiextreme;

--
-- Name: dbms_profiler; Type: SCHEMA; Schema: -; Owner: rookiextreme
--

CREATE SCHEMA dbms_profiler;


ALTER SCHEMA dbms_profiler OWNER TO rookiextreme;

--
-- Name: dbms_random; Type: SCHEMA; Schema: -; Owner: rookiextreme
--

CREATE SCHEMA dbms_random;


ALTER SCHEMA dbms_random OWNER TO rookiextreme;

--
-- Name: dbms_scheduler; Type: SCHEMA; Schema: -; Owner: rookiextreme
--

CREATE SCHEMA dbms_scheduler;


ALTER SCHEMA dbms_scheduler OWNER TO rookiextreme;

--
-- Name: dbo; Type: SCHEMA; Schema: -; Owner: rookiextreme
--

CREATE SCHEMA dbo;


ALTER SCHEMA dbo OWNER TO rookiextreme;

--
-- Name: SCHEMA dbo; Type: COMMENT; Schema: -; Owner: rookiextreme
--

COMMENT ON SCHEMA dbo IS 'dbo schema';


--
-- Name: sys; Type: SCHEMA; Schema: -; Owner: rookiextreme
--

CREATE SCHEMA sys;


ALTER SCHEMA sys OWNER TO rookiextreme;

--
-- Name: SCHEMA sys; Type: COMMENT; Schema: -; Owner: rookiextreme
--

COMMENT ON SCHEMA sys IS 'sys schema';


--
-- Name: dss_freq_enum; Type: TYPE; Schema: sys; Owner: rookiextreme
--

CREATE TYPE sys.dss_freq_enum AS ENUM (
    'YEARLY',
    'MONTHLY',
    'WEEKLY',
    'DAILY',
    'HOURLY',
    'MINUTELY',
    'SECONDLY'
);


ALTER TYPE sys.dss_freq_enum OWNER TO rookiextreme;

--
-- Name: dss_program_type_enum; Type: TYPE; Schema: sys; Owner: rookiextreme
--

CREATE TYPE sys.dss_program_type_enum AS ENUM (
    'PLSQL_BLOCK',
    'STORED_PROCEDURE'
);


ALTER TYPE sys.dss_program_type_enum OWNER TO rookiextreme;

--
-- Name: scheduler_0100_component_name_type; Type: TYPE; Schema: sys; Owner: rookiextreme
--

CREATE TYPE sys.scheduler_0100_component_name_type AS (
	dsc_name character varying
);


ALTER TYPE sys.scheduler_0100_component_name_type OWNER TO rookiextreme;

--
-- Name: scheduler_0250_program_argument_type; Type: TYPE; Schema: sys; Owner: rookiextreme
--

CREATE TYPE sys.scheduler_0250_program_argument_type AS (
	dspa_program_id integer,
	dspa_owner character varying,
	dspa_argument_position integer,
	dspa_argument_name character varying,
	dspa_argument_type character varying,
	dspa_default_value character varying,
	dspa_default_value_set boolean,
	dspa_out_argument boolean
);


ALTER TYPE sys.scheduler_0250_program_argument_type OWNER TO rookiextreme;

--
-- Name: scheduler_0400_job_type; Type: TYPE; Schema: sys; Owner: rookiextreme
--

CREATE TYPE sys.scheduler_0400_job_type AS (
	dsj_owner character varying,
	dsj_job_name character varying,
	dsj_job_id integer,
	dsj_program_id integer,
	dsj_schedule_id integer,
	dsj_job_class character varying,
	dsj_enabled boolean,
	dsj_auto_drop boolean,
	dsj_search_path text,
	dsj_comments character varying
);


ALTER TYPE sys.scheduler_0400_job_type OWNER TO rookiextreme;

--
-- Name: scheduler_0450_job_argument_type; Type: TYPE; Schema: sys; Owner: rookiextreme
--

CREATE TYPE sys.scheduler_0450_job_argument_type AS (
	dsja_job_id integer,
	dsja_owner character varying,
	dsja_argument_position integer,
	dsja_argument_name character varying,
	dsja_argument_value character varying
);


ALTER TYPE sys.scheduler_0450_job_argument_type OWNER TO rookiextreme;

--
-- Name: rand(); Type: FUNCTION; Schema: public; Owner: rookiextreme
--

CREATE FUNCTION public.rand() RETURNS double precision
    LANGUAGE sql
    AS $$SELECT random();$$;


ALTER FUNCTION public.rand() OWNER TO rookiextreme;

--
-- Name: substring_index(text, text, integer); Type: FUNCTION; Schema: public; Owner: rookiextreme
--

CREATE FUNCTION public.substring_index(text, text, integer) RETURNS text
    LANGUAGE sql
    AS $_$SELECT array_to_string((string_to_array($1, $2)) [1:$3], $2);$_$;


ALTER FUNCTION public.substring_index(text, text, integer) OWNER TO rookiextreme;

--
-- Name: edbreport(bigint, bigint); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.edbreport(beginsnap bigint, endsnap bigint) RETURNS SETOF text
    LANGUAGE plpgsql
    AS $_$ declare
-- v_topn controls how many rows to report by section
-- v_stattype determines where user,sys or all data is used
v_topn		int := 10;
v_stattype	text := 'all';

v_start 	bigint;
v_end   	bigint;
v_db		text;
v_dbsize	text;
v_tspsize	text;
v_tabsize	numeric;
v_version	text;
v_textstr   	text;
v_currdt	text;

snaprec     	record;
spcrec		record;
nsprec		record;
tabrec		record;
parmrec		record;
toptabrec	record;
topidxrec	record;
rec		record;
dmlrec		record;
bufrec		record;

v_nspcnt	numeric := 0;
have_pg_buffercache_ext bool;

begin

v_start := beginsnap;
v_end   := endsnap;
-- get date/time
-- get period from snapids

select current_database() into v_db;
select version() into v_version;
select current_date into v_currdt;

for snaprec in select sn1.edb_id, sn1.snap_tm as start_tm, sn2.edb_id,
    sn2.snap_tm as end_tm
    from edb$snap as sn1, edb$snap as sn2
    where sn1.edb_id = v_start
    and sn2.edb_id = v_end
    order by sn1.edb_id LOOP

v_textstr := '   EnterpriseDB Report for database '||v_db||'        '||v_currdt;
return next v_textstr;
v_textstr := 'Version: '||v_version;
return next v_textstr;
v_textstr := null;
return next v_textstr;

v_textstr := '     Begin snapshot: '||v_start::text||' at '||snaprec.start_tm;
return next v_textstr;
v_textstr := '     End snapshot:   '||v_end::text||' at '||snaprec.end_tm;
return next v_textstr;

end loop;

-- Get database size
v_textstr := null;
return next v_textstr;

select pg_size_pretty(pg_database_size(v_db)) into v_dbsize;
v_textstr := 'Size of database '||v_db||' is '||v_dbsize;
return next v_textstr;

-- Get tablespace info
for spcrec in select spcname,usename from pg_catalog.pg_tablespace as tsp, pg_user as usr
	where tsp.spcowner = usr.usesysid LOOP

select pg_size_pretty(pg_tablespace_size(spcrec.spcname)) into v_tspsize;

v_textstr := '     Tablespace: '||spcrec.spcname||' Size: '||v_tspsize||' Owner: '||spcrec.usename;
return next v_textstr;

end loop;
v_textstr := null;
return next v_textstr;

-- Get schema info
if v_version like 'EnterpriseDB%' then
	for nsprec in select nspname,usename from pg_catalog.pg_namespace as nsp, pg_user as usr
	where usr.usesysid = nsp.nspowner
	and nsp.nspname not in ('sys','dbo','information_schema','pg_toast','pg_catalog')
	and nsp.nspname not like E'pg\\_temp\\_%'
	and nspheadsrc is null LOOP

	v_nspcnt := 0;

	for tabrec in select schemaname,tablename from pg_tables where schemaname = nsprec.nspname LOOP
	select pg_total_relation_size(tabrec.schemaname||'.'||tabrec.tablename) into v_tabsize;

	v_nspcnt := v_nspcnt + v_tabsize;
	end loop;

	v_textstr := 'Schema: '||rpad(nsprec.nspname,30,' ')||' Size: '||rpad(pg_size_pretty(v_nspcnt::bigint),15,' ')||
	' Owner: '||rpad(nsprec.usename,20,' ');
	return next v_textstr;

	end loop;
else
	for nsprec in select nspname,usename from pg_catalog.pg_namespace as nsp, pg_user as usr
	where usr.usesysid = nsp.nspowner
	and nsp.nspname not in ('sys','dbo','information_schema','pg_toast','pg_catalog')
	and nsp.nspname not like E'pg\\_temp\\_%'
	 LOOP

	v_nspcnt := 0;

	for tabrec in select schemaname,tablename from pg_tables where schemaname = nsprec.nspname LOOP
	select pg_total_relation_size(tabrec.schemaname||'.'||tabrec.tablename) into v_tabsize;

	v_nspcnt := v_nspcnt + v_tabsize;
	end loop;

	v_textstr := 'Schema: '||rpad(nsprec.nspname,30,' ')||' Size: '||rpad(pg_size_pretty(v_nspcnt::bigint),15,' ')||
	' Owner: '||rpad(nsprec.usename,20,' ');
	return next v_textstr;

	end loop;
end if;

v_textstr := null;
return next v_textstr;

-- Get Top 10 largest tables
v_textstr := '               Top 10 Relations by pages';
return next v_textstr;
v_textstr := null;
return next v_textstr;

v_textstr := rpad('TABLE',45,' ')||rpad('RELPAGES',10,' ');
return next v_textstr;
v_textstr := '----------------------------------------------------------------------------------';
return next v_textstr;

for toptabrec in SELECT relname, relpages FROM pg_class 
where relkind = 'r' 
ORDER BY relpages DESC
limit 10 loop

v_textstr := rpad(toptabrec.relname,45,' ')||' '||rpad(toptabrec.relpages::text,10,' ');
return next v_textstr;
end loop;

v_textstr := null;
return next v_textstr;

-- Get Top 10 largest indexes
v_textstr := '               Top 10 Indexes by pages';
return next v_textstr;
v_textstr := null;
return next v_textstr;

v_textstr := rpad('INDEX',45,' ')||rpad('RELPAGES',10,' ');
return next v_textstr;
v_textstr := '----------------------------------------------------------------------------------';
return next v_textstr;

for topidxrec in SELECT relname, relpages FROM pg_class 
where relkind = 'i' 
ORDER BY relpages DESC
limit 10 loop

v_textstr := rpad(topidxrec.relname,45,' ')||' '||rpad(topidxrec.relpages::text,10,' ');
return next v_textstr;

end loop;
v_textstr := null;
return next v_textstr;

-- Top 10 relations by update,delete,insert activity
v_textstr := '               Top 10 Relations by DML';
return next v_textstr;
v_textstr := null;
return next v_textstr;

v_textstr := rpad('SCHEMA',15,' ')||' '||rpad('RELATION',45,' ')||rpad('UPDATES',10,' ')||
rpad('DELETES',10,' ')||rpad('INSERTS',10,' ');
return next v_textstr;
v_textstr := '--------------------------------------------------------------------------------------------------';
return next v_textstr;

for dmlrec in
select schemaname as SCHEMA,
		relname as RELATION,
		n_tup_upd as UPDATES,
		n_tup_del as DELETES,
		n_tup_ins as INSERTS
from pg_stat_user_tables
order by n_tup_upd desc,n_tup_del desc, n_tup_ins desc,schemaname,relname
limit 10 LOOP

v_textstr := rpad(dmlrec.schema,15,' ')||' '||rpad(dmlrec.relation,45,' ')||rpad(dmlrec.updates::text,10,' ')||
rpad(dmlrec.deletes::text,10,' ')||rpad(dmlrec.inserts::text,10,' ');
return next v_textstr;

end loop;

v_textstr := null;
return next v_textstr;

-- Call stat functions
for rec in (select * from  stat_db_rpt(v_start::int4,v_end::int4) z )
	loop
		v_textstr := rec.z;
  		return next v_textstr;
	end loop;
v_textstr := null;
return next v_textstr;

-- If pg_buffercache extension is installed, fetch buffer usage information
select count(*) > 0 from pg_extension where extname = 'pg_buffercache' into have_pg_buffercache_ext;

if have_pg_buffercache_ext then
	-- Top 10 Relations in buffer cache
	v_textstr := '  DATA from pg_buffercache';
	return next v_textstr;
	v_textstr := null;
	return next v_textstr;

	v_textstr := rpad('RELATION',35,' ')||' '||rpad('BUFFERS',10,' ');
	return next v_textstr;
	v_textstr := '-----------------------------------------------------------------------------';
	return next v_textstr;
	for bufrec in
		SELECT c.relname, count(*) AS buffers
		FROM pg_class c
		INNER JOIN pg_buffercache b ON b.relfilenode = c.relfilenode
		INNER JOIN pg_database d ON (b.reldatabase = d.oid AND d.datname = current_database())
		GROUP BY c.relname
		ORDER BY 2 DESC LIMIT 10
	loop
		v_textstr := rpad(bufrec.relname,35,' ')||' '||rpad(bufrec.buffers::text,10,' ');
		return next v_textstr;

	end loop;
	v_textstr := null;
	return next v_textstr;
else
	v_textstr := '  DATA from pg_buffercache not included because pg_buffercache is not installed';
	return next v_textstr;
	v_textstr := null;
	return next v_textstr;
end if;

for rec in (select * from  stat_tables_rpt(v_start::int4,v_end::int4,v_topn,v_stattype) z )
	loop
  		v_textstr := rec.z;
  		return next v_textstr;
	end loop;
v_textstr := null;
return next v_textstr;

for rec in (select * from  statio_tables_rpt(v_start::int4,v_end::int4,v_topn,v_stattype) z )
	loop
  		v_textstr := rec.z;
  		return next v_textstr;
	end loop;
v_textstr := null;
return next v_textstr;
 
for rec in (select * from  stat_indexes_rpt(v_start::int4,v_end::int4,v_topn,v_stattype) z )
	loop
  		v_textstr := rec.z;
  		return next v_textstr;
	end loop;
v_textstr := null;
return next v_textstr;

for rec in (select * from  statio_indexes_rpt(v_start::int4,v_end::int4,v_topn,v_stattype) z )
	loop
  		v_textstr := rec.z;
  		return next v_textstr;
	end loop;
v_textstr := null;
return next v_textstr;

-- Incluce DRITA system data, if Enterprisedb
if v_version like 'EnterpriseDB%' then
    v_textstr := '   System Wait Information';
    return next v_textstr;
	v_textstr := null;
	return next v_textstr;

	for rec in (select * from  sys_rpt(v_start::int4,v_end::int4,v_topn) z )
	loop
  		v_textstr := rec.z;
  		return next v_textstr;
	end loop;
	v_textstr := null;
	return next v_textstr;
end if;

-- Get database parameters
v_textstr := '   Database Parameters from postgresql.conf ';
return next v_textstr;
v_textstr := null;
return next v_textstr;
v_textstr := 'PARAMETER                         SETTING                                  CONTEXT     MINVAL       MAXVAL       ';
return next v_textstr;
v_textstr := '-------------------------------------------------------------------------------------------------------------------------';
return next v_textstr;

for parmrec in select name as parm,
	-- coalesce(unit,'') as unit,
    setting as setting,
-- category,
	coalesce(context,'') as context,
--	coalesce(vartype,'') as vartype,	
	coalesce(min_val,'') as minval,
	coalesce(max_val,'') as maxval
 from pg_settings 
 order by name LOOP

v_textstr := rpad(parmrec.parm,35,' ') -- ||rpad(parmrec.unit,5,' ')
||rpad(parmrec.setting,40,' ')||' '||rpad(parmrec.context,12,' ')||
rpad(parmrec.minval::text,13,' ')||rpad(parmrec.maxval::text,12,' ');
return next v_textstr;

end loop;
end;
               $_$;


ALTER FUNCTION sys.edbreport(beginsnap bigint, endsnap bigint) OWNER TO rookiextreme;

--
-- Name: edbsnap(); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.edbsnap() RETURNS text
    LANGUAGE plpgsql
    AS $_$    
 
declare
v_seq   bigint;
v_db    name;
msg     text;
v_version text;
v_stats_cnt	numeric :=0;

begin
select nextval('snapshot_num_seq') into v_seq;
select current_database() into v_db;
select version() into v_version;
/*
select count(*) into v_stats_cnt from pg_settings
	where name in ('stats_block_level','stats_row_level')
	and setting = 'on';

if v_stats_cnt < 2 then
	msg := 'Stats_block_level and stats_row_level parameters should be set = on.';
	return msg;
	exit;
end if;
*/
	
insert into edb$snap
values (v_seq,
        v_db,
     now(),
     null      ,
     null,
     null,
     'N')
;

if v_version like 'EnterpriseDB%' then
	insert into edb$system_waits
		select v_seq,v_db,
		wait_name  ,
		wait_count  ,
		avg_wait  ,
		max_wait  ,
		total_wait
		from system_waits;
 
	insert into edb$session_waits
		select v_seq, v_db,
		backend_id   ,
		wait_name   ,
		wait_count     ,
		avg_wait_time    ,
		max_wait_time    ,
		total_wait_time  
		, usename, query
			from session_waits LEFT OUTER JOIN pg_stat_activity 
			on backend_id = pg_stat_activity.pid;

	insert into edb$session_wait_history
		select v_seq,
		v_db,
		backend_id   ,
		seq          ,
		wait_name    ,
		elapsed      ,
		p1          ,
		p2           ,
		p3           
		from session_wait_history;
end if;

------------------------------ NEW ------------------------------
insert into edb$stat_all_tables
select v_seq,v_db,
relid              ,                     
 schemaname         ,                 
 relname            ,                
 seq_scan            ,                  
 seq_tup_read        ,                  
 idx_scan            ,                  
 idx_tup_fetch       ,                  
 n_tup_ins           ,                  
 n_tup_upd          ,                 
 n_tup_del         -- ,                 
 -- last_vacuum         ,
 -- last_autovacuum     ,
 -- last_analyze        ,
 -- last_autoanalyze   
from pg_stat_all_tables;

insert into edb$stat_all_indexes
select v_seq,v_db,
relid           ,   
 indexrelid       ,   
 schemaname       ,
 relname          ,
 indexrelname     ,
 idx_scan         ,
 idx_tup_read     ,
 idx_tup_fetch   
from pg_stat_all_indexes;

insert into edb$statio_all_tables
select v_seq,v_db,
relid             ,  
 schemaname        ,
 relname            ,
 heap_blks_read     ,
 heap_blks_hit     , 
 heap_blks_icache_hit,
 idx_blks_read      ,
 idx_blks_hit       ,
 idx_blks_icache_hit,
 toast_blks_read    ,
 toast_blks_hit     ,
 toast_blks_icache_hit,
 tidx_blks_read     ,
 tidx_blks_hit      ,
 tidx_blks_icache_hit
from pg_statio_all_tables;

insert into edb$statio_all_indexes
select v_seq,v_db,
relid           ,  
 indexrelid        ,  
 schemaname      , 
 relname          ,
 indexrelname     ,
 idx_blks_read    ,
 idx_blks_hit     ,
 idx_blks_icache_hit
from pg_statio_all_indexes;

insert into edb$stat_database
select v_seq,v_db,
datid           ,    
 datname          ,
 numbackends      ,
 xact_commit      ,
 xact_rollback   , 
 blks_read         ,
 blks_hit          ,
 blks_icache_hit
from pg_stat_database;
------------------------------ END OF NEW -----------------------
 
msg := 'Statement processed.';
return msg;
/* 
exception
when others then
msg := 'Unsupported version.';
return msg;
*/ 
end;

  $_$;


ALTER FUNCTION sys.edbsnap() OWNER TO rookiextreme;

--
-- Name: get_snaps(); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.get_snaps() RETURNS SETOF text
    LANGUAGE plpgsql
    AS $_$    

declare
textstr text;
rec RECORD;
begin

for rec in
(select edb_id, snap_tm 
from edb$snap
order by edb_id  )  loop
textstr := rec.edb_id||' '||rec.snap_tm;
return next textstr;
end loop;


return;
end;

  $_$;


ALTER FUNCTION sys.get_snaps() OWNER TO rookiextreme;

--
-- Name: purgesnap(integer, integer); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.purgesnap(integer, integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$ 
declare
bid     alias for $1;
eid     alias for $2;
msg text;

rowcnt  int;

begin

delete from edb$system_waits where edb_id between bid and eid;
delete from edb$session_waits where edb_id between bid and eid; 
delete from edb$session_wait_history where edb_id between bid and eid; 
delete from edb$snap where edb_id between bid and eid; 
-- added 01/07/2008 - P. Steinheuser
delete from edb$stat_database where edb_id between bid and eid; 
delete from edb$stat_all_tables where edb_id between bid and eid; 
delete from edb$statio_all_tables where edb_id between bid and eid; 
delete from edb$stat_all_indexes where edb_id between bid and eid; 
delete from edb$statio_all_indexes where edb_id between bid and eid; 

get diagnostics rowcnt = ROW_COUNT;

if rowcnt = 0  then
  msg := 'Snapshots not found.';
else
    msg := 'Snapshots in range '||bid||' to '||eid||' deleted.';
end if;

-- msg := 'Rows deleted = '||rowcnt;
  return msg;

exception
when others then
msg := 'Function failed.';
return msg;
end;

   $_$;


ALTER FUNCTION sys.purgesnap(integer, integer) OWNER TO rookiextreme;

--
-- Name: sess_rpt(integer, integer, integer); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.sess_rpt(integer, integer, integer) RETURNS SETOF text
    LANGUAGE plpgsql
    AS $_$       

declare
bid     alias for $1;
eid     alias for $2;
topn    alias for $3;

textstr text;
rec RECORD;
begin

textstr := 'ID   '||' '||rpad('USER',10,' ')||' '||rpad('WAIT NAME',30,' ')||' '||rpad('COUNT',5,' ')||
' '||rpad('TIME(ms)',12,' ')||' '||rpad('% WAIT SESS',10)||' '||'% WAIT ALL';

return next textstr;
textstr := '---------------------------------------------------------------------------------------------------';
return next textstr;

for rec in (select fv.backend_id,
        fv.usename,
        fv.wait_name,
        fv.waitcnt,
        fv.totwait,
        -- sw.sumwait, tw.twaits
        round(100* (fv.totwait/sw.sumwait),2) as pctwaitsess,
        round(100 *(fv.totwait/tw.twaits),2) as pctwaitall 
 from (
 select e.backend_id, 
          e.usename,
          e.wait_name,
          abs(e.wait_count - b.wait_count)  as waitcnt,   		 
          abs(e.total_wait_time - b.total_wait_time)  as totwait      
             from  edb$session_waits  as b
                    ,  edb$session_waits  as e
                  where b.edb_id              	= bid
                  and e.edb_id              	= eid
                  and b.dbname              	= e.dbname
                  and b.wait_name           	= e.wait_name
                  and b.backend_id 		= e.backend_id
                  and (b.total_wait_time > 0 or e.total_wait_time > 0)
              order by backend_id, totwait desc ) as fv , 
 	(select e2.backend_id,sum(abs(e2.total_wait_time-b2.total_wait_time)) as sumwait 
		from edb$session_waits b2,
                    edb$session_waits e2
		where b2.edb_id = bid 
                    and e2.edb_id = eid
                      and b2.backend_id = e2.backend_id
                      and b2.wait_name = e2.wait_name
            	group by e2.backend_id having sum(abs(e2.total_wait_time-b2.total_wait_time)) > 0 
                order by e2.backend_id 	) as sw  ,          
    (select sum(abs(e3.total_wait_time - b3.total_wait_time)) as twaits  
    		from edb$session_waits b3, edb$session_waits e3
 		where b3.edb_id = bid and e3.edb_id = eid
                and b3.backend_id = e3.backend_id
		and b3.wait_name = e3.wait_name) as tw
where fv.backend_id = sw.backend_id
        limit topn)  LOOP   
                                 
textstr := rec.backend_id||' '||rpad(rec.usename,10,' ')||' '||rpad(rec.wait_name,30,' ')||' '||
rpad(rec.waitcnt::text,5,' ')||' '||rpad(rec.totwait::text,12,' ')||' '||rpad(rec.pctwaitsess::text,10,' ')||' '||rec.pctwaitall;

return next textstr;
end loop;

return;
end;
 $_$;


ALTER FUNCTION sys.sess_rpt(integer, integer, integer) OWNER TO rookiextreme;

--
-- Name: sesshist_rpt(integer, integer); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.sesshist_rpt(integer, integer) RETURNS SETOF text
    LANGUAGE plpgsql
    AS $_$         

declare
snapid     	alias for $1;
sessid  	alias for $2;

textstr text;
rec RECORD;
begin

textstr := 'ID   '||' '||rpad('USER',10,' ')||rpad('SEQ',5,' ')||' '||rpad('WAIT NAME',24,' ')||' '||
rpad('ELAPSED(ms)',12,' ')||' '||rpad('File',6,' ')||' '||rpad('Name',20,' ')||' '||rpad('# of Blk',10,' ')||' '||rpad('Sum of Blks',12,' ');

return next textstr;
textstr := '---------------------------------------------------------------------------------------------------';
return next textstr;

for rec in (
   select b.backend_id, 
          w.usename,
	  b.seq,
          b.wait_name,
          b.elapsed,   		 
          b.p1,     
          c.relname as relname,   
	  b.p2 as p2,     
	  sum(b.p3) as p3          
            from  edb$session_wait_history  as b,
                  edb$session_waits as w,
                  (select relfilenode,relname from pg_class
                  union
                  select 0,'N/A') as c  -- added this to handle file=0 for query plan
                  where b.edb_id              	= snapid
                  and b.backend_id              = sessid
		  and b.backend_id              = w.backend_id
		  and b.dbname                  = w.dbname
		  and b.wait_name               = w.wait_name
		  and b.edb_id                  = w.edb_id
                  and b.p1                      = c.relfilenode
             group by b.backend_id, 
          w.usename,
	  b.seq,
          b.wait_name,
          b.elapsed,
           b.p1 , c.relname, b.p2      
              order by backend_id, seq   
         )  LOOP   
                                 
textstr := rec.backend_id||' '||rpad(rec.usename,10,' ')||' '||rpad(rec.seq::text,5,' ')||' '||rpad(rec.wait_name,24,' ')||
' '||rpad(rec.elapsed::text,12,' ')||' '||rpad(rec.p1::text,6,' ')||' '||rpad(rec.relname,20,' ')||' '||rpad(rec.p2::text,10,' ')||' '||rpad(rec.p3::text,12,' ');

return next textstr;
end loop;

return;
end;
   $_$;


ALTER FUNCTION sys.sesshist_rpt(integer, integer) OWNER TO rookiextreme;

--
-- Name: sessid_rpt(integer, integer, integer); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.sessid_rpt(integer, integer, integer) RETURNS SETOF text
    LANGUAGE plpgsql
    AS $_$       

declare
bid     alias for $1;
eid     alias for $2;
sessid    alias for $3;

textstr text;
rec RECORD;
begin

textstr := 'ID   '||' '||rpad('USER',10,' ')||' '||rpad('WAIT NAME',30,' ')||' '||rpad('COUNT',5,' ')||
' '||rpad('TIME(ms)',12,' ')||' '||rpad('% WAIT SESS',10)||' '||'% WAIT ALL';

return next textstr;
textstr := '---------------------------------------------------------------------------------------------------';
return next textstr;

for rec in (select fv.backend_id,
        fv.usename,
        fv.wait_name,
        fv.waitcnt,
        fv.totwait,
        round(100* (fv.totwait/sw.sumwait),2) as pctwaitsess,
        round(100 *(fv.totwait/tw.twaits),2) as pctwaitall 
 from (
 select e.backend_id, 
          e.usename,
          e.wait_name,
          abs(e.wait_count - b.wait_count)  as waitcnt,   		 
          abs(e.total_wait_time - b.total_wait_time)  as totwait      
            from  edb$session_waits  as b
                    ,  edb$session_waits  as e
                  where b.edb_id              	= bid
                  and e.edb_id              	= eid
                  and b.dbname              	= e.dbname
                  and b.wait_name           	= e.wait_name
                  and b.backend_id 		= e.backend_id
		and b.backend_id	= sessid
                  and (b.total_wait_time > 0 or e.total_wait_time > 0)
              order by backend_id, totwait desc ) as fv , 
 	(select e2.backend_id,sum(abs(e2.total_wait_time-b2.total_wait_time)) as sumwait 
		from edb$session_waits b2,
                    edb$session_waits e2
		where b2.edb_id = bid 
                    and e2.edb_id = eid
		and e2.wait_name = b2.wait_name
                      and b2.backend_id = e2.backend_id
		and b2.backend_id = sessid
            	group by e2.backend_id having sum(abs(e2.total_wait_time-b2.total_wait_time)) > 0 
                order by e2.backend_id 	) as sw  ,          
    (select sum(abs(e3.total_wait_time - b3.total_wait_time)) as twaits  
    		from edb$session_waits b3, edb$session_waits e3
 		where b3.edb_id = bid and e3.edb_id = eid
		and b3.backend_id = e3.backend_id
		and b3.wait_name = e3.wait_name) as tw
where fv.backend_id = sw.backend_id
        -- limit topn
)  LOOP   
                                 
textstr := rec.backend_id||' '||rpad(rec.usename,10,' ')||' '||rpad(rec.wait_name,30,' ')||' '||
rpad(rec.waitcnt::text,5,' ')||' '||rpad(rec.totwait::text,12,' ')||' '||rpad(rec.pctwaitsess::text,10,' ')||' '||rec.pctwaitall;

return next textstr;
end loop;

return;
end;
 $_$;


ALTER FUNCTION sys.sessid_rpt(integer, integer, integer) OWNER TO rookiextreme;

--
-- Name: stat_db_rpt(integer, integer); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.stat_db_rpt(p_bid integer, p_eid integer) RETURNS SETOF text
    LANGUAGE plpgsql
    AS $_$declare
v_bid       int4;
v_eid       int4;
v_db        text;

v_hitrate	numeric;

textstr text;
rec RECORD;

begin

select current_database() into v_db;

textstr := '  DATA from pg_stat_database';
return next textstr;
textstr := null;
return next textstr;

textstr := rpad('DATABASE',10,' ')||' '||rpad('NUMBACKENDS',12,' ')||' '||rpad('XACT COMMIT',12,' ')||
' '||rpad('XACT ROLLBACK',15,' ')||' '||rpad('BLKS READ',10,' ')||' '||rpad('BLKS HIT',10,' ')||
' '||rpad('BLKS ICACHE HIT',20,' ')||' '||rpad('HIT RATIO',10,' ')||' '||rpad('ICACHE HIT RATIO',20,' ');
return next textstr;
textstr := rpad('-', 126, '-'); -- (126 = 10*4 + 12*2 + 15 + 20*2 + 6 spaces)
return next textstr;
 
v_bid := p_bid;
v_eid := p_eid;

-----------------------------------------------------------------------------
-- NOTE: blks_fetch = blks_read + blks_hit + blks_icache_hit
-- blks_read are actual reads from the disk if the blk is not found in the 
-- shared buffers or the InfiniteCache
-- hence, hitrate is calculated as blks_hit / blks_fetch, 
-- similarly icachehitrate is calculated as blks_icache_hit / blks_fetch
-----------------------------------------------------------------------------
for rec in (
select e.datname,
	(e.numbackends - b.numbackends)  as numbackends,   	 
    (e.xact_commit - b.xact_commit)  as xact_commit,       
	(e.xact_rollback - b.xact_rollback) as xact_rollback,
	(e.blks_read - b.blks_read) as blks_read,
	(e.blks_hit - b.blks_hit) as blks_hit,
	(e.blks_icache_hit - b.blks_icache_hit) as blks_icache_hit,
    round(100 * ( (e.blks_hit - b.blks_hit)/( (e.blks_read - b.blks_read) + (e.blks_hit - b.blks_hit) + (e.blks_icache_hit - b.blks_icache_hit) )::numeric),2) as hitrate,
    round(100 * ( (e.blks_icache_hit - b.blks_icache_hit)/( (e.blks_read - b.blks_read) + (e.blks_hit - b.blks_hit) + (e.blks_icache_hit - b.blks_icache_hit) )::numeric),2) as icachehitrate
from edb$stat_database as e
    ,edb$stat_database as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.datname = v_db 
and e.datname = v_db
and ((e.blks_read - b.blks_read) + (e.blks_hit - b.blks_hit) + (e.blks_icache_hit - b.blks_icache_hit)) <> 0)
	 LOOP

textstr := rpad(rec.datname,10,' ')||' '||rpad(rec.numbackends::text,12,' ')||' '||rpad(rec.xact_commit::text,12,' ')||
' '||rpad(rec.xact_rollback::text,15,' ')||' '||rpad(rec.blks_read::text,10,' ')||' '||rpad(rec.blks_hit::text,10,' ')||
' '||rpad(rec.blks_icache_hit::text,20,' ')||' '||rpad(rec.hitrate::text,10,' ')||' '||rpad(rec.icachehitrate::text,20,' ');
return next textstr;
end loop;

return;
end;
         $_$;


ALTER FUNCTION sys.stat_db_rpt(p_bid integer, p_eid integer) OWNER TO rookiextreme;

--
-- Name: stat_indexes_rpt(integer, integer, integer, text); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.stat_indexes_rpt(p_bid integer, p_eid integer, p_topn integer, p_stat text) RETURNS SETOF text
    LANGUAGE plpgsql
    AS $_$declare
v_bid       int4;
v_eid       int4;
v_topn      int4;
v_stat      text;

textstr text;
rec RECORD;

refcur  refcursor;

begin
textstr := '  DATA from pg_stat_all_indexes';
return next textstr;
textstr := null;
return next textstr;

textstr := rpad('SCHEMA',20,' ')||' '||rpad('RELATION',25,' ')||' '||rpad('INDEX',35,' ')||' '||rpad('IDX SCAN',10,' ')||
' '||rpad('IDX TUP READ',12,' ')||' '||rpad('IDX TUP FETCH',15,' ');
return next textstr;
textstr := '-------------------------------------------------------------------------------------------------------------------------';
return next textstr;
 
v_bid := p_bid;
v_eid := p_eid;
v_topn := p_topn;
v_stat := upper(p_stat);

if v_stat not in ('ALL','USER','SYS') then
	raise exception 'Invalid stat type.';
end if;

if v_stat = 'ALL' then
 open refcur for
select e.schemaname,
	e.relname,
	e.indexrelname,
    e.idx_scan - b.idx_scan  as idx_scan,   	 
    e.idx_tup_read - b.idx_tup_read  as idx_tup_read,       
	e.idx_tup_fetch - b.idx_tup_fetch as idx_tup_fetch
from edb$stat_all_indexes as e
    ,edb$stat_all_indexes as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and b.indexrelname	  = e.indexrelname
    order by idx_scan desc, indexrelname   
    limit p_topn;
elsif v_stat = 'USER' then
  open refcur for
select e.schemaname,
	e.relname,
	e.indexrelname,
    e.idx_scan - b.idx_scan  as idx_scan,   	 
    e.idx_tup_read - b.idx_tup_read  as idx_tup_read,       
	e.idx_tup_fetch - b.idx_tup_fetch as idx_tup_fetch
from edb$stat_all_indexes as e
    ,edb$stat_all_indexes as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and b.indexrelname	  = e.indexrelname
and e.schemaname in (select distinct schemaname from pg_stat_user_indexes)
    order by idx_scan desc, indexrelname   
    limit p_topn;
elsif v_stat = 'SYS' then
  open refcur for
select e.schemaname,
	e.relname,
	e.indexrelname,
    e.idx_scan - b.idx_scan  as idx_scan,   	 
    e.idx_tup_read - b.idx_tup_read  as idx_tup_read,       
	e.idx_tup_fetch - b.idx_tup_fetch as idx_tup_fetch
from edb$stat_all_indexes as e
    ,edb$stat_all_indexes as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and b.indexrelname	  = e.indexrelname
and e.schemaname in (select distinct schemaname from pg_stat_sys_indexes)
    order by idx_scan desc, indexrelname   
    limit p_topn;
end if;

loop
fetch refcur into rec;
exit when not found;

textstr := rpad(rec.schemaname,20,' ')||' '||rpad(rec.relname,25,' ')||' '||rpad(rec.indexrelname,35,' ')||
' '||rpad(rec.idx_scan::text,10,' ')||' '||rpad(rec.idx_tup_read::text,12,' ')||' '||rpad(rec.idx_tup_fetch::text,15,' ');
return next textstr;
end loop;

close refcur;
return;
end;
          $_$;


ALTER FUNCTION sys.stat_indexes_rpt(p_bid integer, p_eid integer, p_topn integer, p_stat text) OWNER TO rookiextreme;

--
-- Name: stat_tables_rpt(integer, integer, integer, text); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.stat_tables_rpt(p_bid integer, p_eid integer, p_topn integer, p_stat text) RETURNS SETOF text
    LANGUAGE plpgsql
    AS $_$declare
v_bid       int4;
v_eid       int4;
v_topn      int4;
v_stat      text;

textstr text;
rec RECORD;

refcur  refcursor;

begin
textstr := '  DATA from pg_stat_all_tables ordered by seq scan';
return next textstr;
textstr := null;
return next textstr;

textstr := rpad('SCHEMA',20,' ')||' '||rpad('RELATION',30,' ')||' '||rpad('SEQ SCAN',10,' ')||
' '||rpad('REL TUP READ',12,' ')||' '||rpad('IDX SCAN',10,' ')||' '||rpad('IDX TUP READ',12,' ')||
' '||rpad('INS',6,' ')||' '||rpad('UPD',6,' ')||' '||rpad('DEL',6,' ');
return next textstr;
textstr := '-----------------------------------------------------------------------------------------------------------------------';
return next textstr;
 
v_bid := p_bid;
v_eid := p_eid;
v_topn := p_topn;
v_stat := upper(p_stat);

if v_stat not in ('ALL','USER','SYS') then
	raise exception 'Invalid stat type.';
end if;

if v_stat = 'ALL' then
 open refcur for
select e.schemaname,
	 e.relname,
     e.seq_scan - b.seq_scan   as seq_scan,   	 
     e.seq_tup_read - b.seq_tup_read  as seq_tup_read,       
	 e.idx_scan - b.idx_scan as idx_scan,
	 e.idx_tup_fetch - b.idx_tup_fetch as idx_tup_fetch,
	 e.n_tup_ins - b.n_tup_ins as ins,
	 e.n_tup_upd - b.n_tup_upd as upd,
	 e.n_tup_del - b.n_tup_del as del 
from edb$stat_all_tables as e
    ,edb$stat_all_tables as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		      = e.relname
and b.idx_scan is not null
and e.idx_scan is not null
and b.idx_tup_fetch is not null
and e.idx_tup_fetch is not null
    order by seq_scan desc, relname   
    limit p_topn;
elsif v_stat = 'USER' then
  open refcur for
select e.schemaname,
	e.relname,
    e.seq_scan - b.seq_scan   as seq_scan,   	 
    e.seq_tup_read - b.seq_tup_read   as seq_tup_read,       
	e.idx_scan - b.idx_scan  as idx_scan,
	e.idx_tup_fetch - b.idx_tup_fetch  as idx_tup_fetch,
	e.n_tup_ins - b.n_tup_ins  as ins,
	e.n_tup_upd - b.n_tup_upd  as upd,
	e.n_tup_del - b.n_tup_del  as del 
from edb$stat_all_tables as e
    ,edb$stat_all_tables as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and b.idx_scan is not null
and e.idx_scan is not null
and b.idx_tup_fetch is not null
and e.idx_tup_fetch is not null
and e.schemaname in (select distinct schemaname from pg_stat_user_tables)
    order by seq_scan desc, relname   
    limit p_topn;
elsif v_stat = 'SYS' then
  open refcur for
select e.schemaname,
	e.relname,
    e.seq_scan - b.seq_scan  as seq_scan,   	 
    e.seq_tup_read - b.seq_tup_read  as seq_tup_read,       
	e.idx_scan - b.idx_scan as idx_scan,
	e.idx_tup_fetch - b.idx_tup_fetch as idx_tup_fetch,
	e.n_tup_ins - b.n_tup_ins as ins,
	e.n_tup_upd - b.n_tup_upd as upd,
	e.n_tup_del - b.n_tup_del as del 
from edb$stat_all_tables as e
    ,edb$stat_all_tables as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and b.idx_scan is not null
and e.idx_scan is not null
and b.idx_tup_fetch is not null
and e.idx_tup_fetch is not null
and e.schemaname in (select distinct schemaname from pg_stat_sys_tables)
    order by seq_scan desc, relname   
    limit p_topn;
end if;

loop
fetch refcur into rec;
exit when not found;

textstr := rpad(rec.schemaname,20,' ')||' '||rpad(rec.relname,30,' ')||' '||rpad(rec.seq_scan::text,10,' ')||
' '||rpad(rec.seq_tup_read::text,12,' ')||' '||rpad(rec.idx_scan::text,10,' ')||' '||rpad(rec.idx_tup_fetch::text,12,' ')||
' '||rpad(rec.ins::text,6,' ')||' '||rpad(rec.upd::text,6,' ')||' '||rpad(rec.del::text,6,' ');
return next textstr;
end loop;

close refcur;

textstr := null;
return next textstr;
textstr := '  DATA from pg_stat_all_tables ordered by rel tup read';
return next textstr;
textstr := null;
return next textstr;

textstr := rpad('SCHEMA',20,' ')||' '||rpad('RELATION',30,' ')||' '||rpad('SEQ SCAN',10,' ')||
' '||rpad('REL TUP READ',12,' ')||' '||rpad('IDX SCAN',10,' ')||' '||rpad('IDX TUP READ',12,' ')||
' '||rpad('INS',6,' ')||' '||rpad('UPD',6,' ')||' '||rpad('DEL',6,' ');
return next textstr;
textstr := '-----------------------------------------------------------------------------------------------------------------------';
return next textstr;

if v_stat = 'ALL' then
 open refcur for
select e.schemaname,
	 e.relname,
     e.seq_scan - b.seq_scan   as seq_scan,   	 
     e.seq_tup_read - b.seq_tup_read  as seq_tup_read,       
	 e.idx_scan - b.idx_scan as idx_scan,
	 e.idx_tup_fetch - b.idx_tup_fetch as idx_tup_fetch,
	 e.n_tup_ins - b.n_tup_ins as ins,
	 e.n_tup_upd - b.n_tup_upd as upd,
	 e.n_tup_del - b.n_tup_del as del 
from edb$stat_all_tables as e
    ,edb$stat_all_tables as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		      = e.relname
and b.idx_scan is not null
and e.idx_scan is not null
and b.idx_tup_fetch is not null
and e.idx_tup_fetch is not null
    order by seq_tup_read desc, relname   
    limit p_topn;
elsif v_stat = 'USER' then
  open refcur for
select e.schemaname,
	e.relname,
    e.seq_scan - b.seq_scan   as seq_scan,   	 
    e.seq_tup_read - b.seq_tup_read   as seq_tup_read,       
	e.idx_scan - b.idx_scan  as idx_scan,
	e.idx_tup_fetch - b.idx_tup_fetch  as idx_tup_fetch,
	e.n_tup_ins - b.n_tup_ins  as ins,
	e.n_tup_upd - b.n_tup_upd  as upd,
	e.n_tup_del - b.n_tup_del  as del 
from edb$stat_all_tables as e
    ,edb$stat_all_tables as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and b.idx_scan is not null
and e.idx_scan is not null
and b.idx_tup_fetch is not null
and e.idx_tup_fetch is not null
and e.schemaname in (select distinct schemaname from pg_stat_user_tables)
    order by seq_tup_read desc, relname   
    limit p_topn;
elsif v_stat = 'SYS' then
  open refcur for
select e.schemaname,
	e.relname,
    e.seq_scan - b.seq_scan  as seq_scan,   	 
    e.seq_tup_read - b.seq_tup_read  as seq_tup_read,       
	e.idx_scan - b.idx_scan as idx_scan,
	e.idx_tup_fetch - b.idx_tup_fetch as idx_tup_fetch,
	e.n_tup_ins - b.n_tup_ins as ins,
	e.n_tup_upd - b.n_tup_upd as upd,
	e.n_tup_del - b.n_tup_del as del 
from edb$stat_all_tables as e
    ,edb$stat_all_tables as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and b.idx_scan is not null
and e.idx_scan is not null
and b.idx_tup_fetch is not null
and e.idx_tup_fetch is not null
and e.schemaname in (select distinct schemaname from pg_stat_sys_tables)
    order by seq_tup_read desc, relname   
    limit p_topn;
end if;

loop
fetch refcur into rec;
exit when not found;

textstr := rpad(rec.schemaname,20,' ')||' '||rpad(rec.relname,30,' ')||' '||rpad(rec.seq_scan::text,10,' ')||
' '||rpad(rec.seq_tup_read::text,12,' ')||' '||rpad(rec.idx_scan::text,10,' ')||' '||rpad(rec.idx_tup_fetch::text,12,' ')||
' '||rpad(rec.ins::text,6,' ')||' '||rpad(rec.upd::text,6,' ')||' '||rpad(rec.del::text,6,' ');
return next textstr;
end loop;

close refcur;

return;
end;
         $_$;


ALTER FUNCTION sys.stat_tables_rpt(p_bid integer, p_eid integer, p_topn integer, p_stat text) OWNER TO rookiextreme;

--
-- Name: statio_indexes_rpt(integer, integer, integer, text); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.statio_indexes_rpt(p_bid integer, p_eid integer, p_topn integer, p_stat text) RETURNS SETOF text
    LANGUAGE plpgsql
    AS $_$declare
v_bid       int4;
v_eid       int4;
v_topn      int4;
v_stat      text;

textstr text;
rec RECORD;

refcur  refcursor;

begin
textstr := '  DATA from pg_statio_all_indexes';
return next textstr;
textstr := null;
return next textstr;

textstr := rpad('SCHEMA',20,' ')||' '||rpad('RELATION',25,' ')||' '||rpad('INDEX',35,' ')||' '||rpad('IDX BLKS READ',15,' ')||
' '||rpad('IDX BLKS HIT',15,' ')||' '||rpad('IDX BLKS ICACHE HIT',20,' ');
return next textstr;
textstr := rpad('-',135,'-'); -- (135 = 20*2 + 25 + 35 + 15*2 + 5 spaces)
return next textstr;
 
v_bid := p_bid;
v_eid := p_eid;
v_topn := p_topn;
v_stat := upper(p_stat);

if v_stat not in ('ALL','USER','SYS') then
	raise exception 'Invalid stat type.';
end if;

if v_stat = 'ALL' then
 open refcur for
select e.schemaname,
	e.relname,
	e.indexrelname,
    e.idx_blks_read - b.idx_blks_read  as idx_blks_read,       
	e.idx_blks_hit - b.idx_blks_hit as idx_blks_hit,
	e.idx_blks_icache_hit - b.idx_blks_icache_hit as idx_blks_icache_hit
from edb$statio_all_indexes as e
    ,edb$statio_all_indexes as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and b.indexrelname	  = e.indexrelname
    order by idx_blks_hit desc, indexrelname   
    limit p_topn;
elsif v_stat = 'USER' then
  open refcur for
select e.schemaname,
	e.relname,
	e.indexrelname,
    e.idx_blks_read - b.idx_blks_read  as idx_blks_read,       
	e.idx_blks_hit - b.idx_blks_hit as idx_blks_hit,
	e.idx_blks_icache_hit - b.idx_blks_icache_hit as idx_blks_icache_hit
from edb$statio_all_indexes as e
    ,edb$statio_all_indexes as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and b.indexrelname	  = e.indexrelname
and e.schemaname in (select distinct schemaname from pg_statio_user_indexes)
    order by idx_blks_hit desc, indexrelname   
    limit p_topn;
elsif v_stat = 'SYS' then
  open refcur for
select e.schemaname,
	e.relname,
	e.indexrelname,
    e.idx_blks_read - b.idx_blks_read  as idx_blks_read,       
	e.idx_blks_hit - b.idx_blks_hit as idx_blks_hit,
	e.idx_blks_icache_hit - b.idx_blks_icache_hit as idx_blks_icache_hit
from edb$statio_all_indexes as e
    ,edb$statio_all_indexes as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and b.indexrelname	  = e.indexrelname
and e.schemaname in (select distinct schemaname from pg_statio_sys_indexes)
    order by idx_blks_hit desc, indexrelname   
    limit p_topn;
end if;

loop
fetch refcur into rec;
exit when not found;

textstr := rpad(rec.schemaname,20,' ')||' '||rpad(rec.relname,25,' ')||' '||rpad(rec.indexrelname,35,' ')||
' '||rpad(rec.idx_blks_read::text,15,' ')||' '||rpad(rec.idx_blks_hit::text,15,' ')||' '||rpad(rec.idx_blks_icache_hit::text,20,' ');
return next textstr;
end loop;

close refcur;
return;
end;
         $_$;


ALTER FUNCTION sys.statio_indexes_rpt(p_bid integer, p_eid integer, p_topn integer, p_stat text) OWNER TO rookiextreme;

--
-- Name: statio_tables_rpt(integer, integer, integer, text); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.statio_tables_rpt(p_bid integer, p_eid integer, p_topn integer, p_stat text) RETURNS SETOF text
    LANGUAGE plpgsql
    AS $_$declare
v_bid       int4;
v_eid       int4;
v_topn      int4;
v_stat      text;

textstr text;
rec RECORD;

refcur  refcursor;

begin
textstr := '  DATA from pg_statio_all_tables';
return next textstr;
textstr := null;
return next textstr;

textstr := rpad('SCHEMA',20,' ')||' '||rpad('RELATION',20,' ')||
' '||rpad('HEAP',8,' ') ||' '||rpad('HEAP',8,' ') ||' '||rpad('HEAP',8,' ')||
' '||rpad('IDX',8,' ')  ||' '||rpad('IDX',8,' ')  ||' '||rpad('IDX',8,' ')||
' '||rpad('TOAST',8,' ')||' '||rpad('TOAST',8,' ')||' '||rpad('TOAST',8,' ')||
' '||rpad('TIDX',8,' ') ||' '||rpad('TIDX',8,' ') ||' '||rpad('TIDX',8,' ');
return next textstr;
textstr := rpad('      ',20,' ')||' '||rpad('        ',20,' ')||
' '||rpad('READ',8,' ')||' '||rpad('HIT',8,' ')||' '||rpad('ICACHE',8,' ')||
' '||rpad('READ',8,' ')||' '||rpad('HIT',8,' ')||' '||rpad('ICACHE',8,' ')||
' '||rpad('READ',8,' ')||' '||rpad('HIT',8,' ')||' '||rpad('ICACHE',8,' ')||
' '||rpad('READ',8,' ')||' '||rpad('HIT',8,' ')||' '||rpad('ICACHE',8,' ');
return next textstr;
textstr := rpad('      ',20,' ')||' '||rpad('        ',20,' ')||
' '||rpad('    ',8,' ')||' '||rpad('   ',8,' ')||' '||rpad('HIT',8,' ')||
' '||rpad('    ',8,' ')||' '||rpad('   ',8,' ')||' '||rpad('HIT',8,' ')||
' '||rpad('    ',8,' ')||' '||rpad('   ',8,' ')||' '||rpad('HIT',8,' ')||
' '||rpad('    ',8,' ')||' '||rpad('   ',8,' ')||' '||rpad('HIT',8,' ');
return next textstr;
textstr := rpad('-', 149, '-'); -- (149 = 20*2 + 8*12 + 13 spaces)
return next textstr;
 
v_bid := p_bid;
v_eid := p_eid;
v_topn := p_topn;
v_stat := upper(p_stat);

if v_stat not in ('ALL','USER','SYS') then
	raise exception 'Invalid stat type.';
end if;

if v_stat = 'ALL' then
 open refcur for
 select e.schemaname,
	e.relname,
    e.heap_blks_read - b.heap_blks_read  as heap_blks_read,   	 
    e.heap_blks_hit - b.heap_blks_hit  as heap_blks_hit,       
    e.heap_blks_icache_hit - b.heap_blks_icache_hit  as heap_blks_icache_hit,
	coalesce(e.idx_blks_read,0) - coalesce(b.idx_blks_read,0) as idx_blks_read,
	coalesce(e.idx_blks_hit,0) - coalesce(b.idx_blks_hit,0) as idx_blks_hit,
        coalesce(e.idx_blks_icache_hit,0) - coalesce(b.idx_blks_icache_hit,0) as idx_blks_icache_hit,
	coalesce(e.toast_blks_read,0) - coalesce(b.toast_blks_read,0) as toast_blks_read,
	coalesce(e.toast_blks_hit,0) - coalesce(b.toast_blks_hit,0) as toast_blks_hit,
        coalesce(e.toast_blks_icache_hit,0) - coalesce(b.toast_blks_icache_hit,0) as toast_blks_icache_hit,
	coalesce(e.tidx_blks_read,0) - coalesce(b.tidx_blks_read,0) as tidx_blks_read,
 	coalesce(e.tidx_blks_hit,0) - coalesce(b.tidx_blks_hit,0) as tidx_blks_hit,
        coalesce(e.tidx_blks_icache_hit,0) - coalesce(b.tidx_blks_icache_hit,0) as tidx_blks_icache_hit
from edb$statio_all_tables as e
    ,edb$statio_all_tables as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
    order by heap_blks_hit desc, relname   
    limit p_topn;
elsif v_stat = 'USER' then
  open refcur for
select e.schemaname,
	e.relname,
    e.heap_blks_read - b.heap_blks_read  as heap_blks_read,   	 
    e.heap_blks_hit - b.heap_blks_hit  as heap_blks_hit,       
    e.heap_blks_icache_hit - b.heap_blks_icache_hit  as heap_blks_icache_hit,
	coalesce(e.idx_blks_read,0) - coalesce(b.idx_blks_read,0) as idx_blks_read,
	coalesce(e.idx_blks_hit,0) - coalesce(b.idx_blks_hit,0) as idx_blks_hit,
	coalesce(e.idx_blks_icache_hit,0) - coalesce(b.idx_blks_icache_hit,0) as idx_blks_icache_hit,
	coalesce(e.toast_blks_read,0) - coalesce(b.toast_blks_read,0) as toast_blks_read,
	coalesce(e.toast_blks_hit,0) - coalesce(b.toast_blks_hit,0) as toast_blks_hit,
	coalesce(e.toast_blks_icache_hit,0) - coalesce(b.toast_blks_icache_hit,0) as toast_blks_icache_hit,
	coalesce(e.tidx_blks_read,0) - coalesce(b.tidx_blks_read,0) as tidx_blks_read,
 	coalesce(e.tidx_blks_hit,0) - coalesce(b.tidx_blks_hit,0) as tidx_blks_hit,
 	coalesce(e.tidx_blks_icache_hit,0) - coalesce(b.tidx_blks_icache_hit,0) as tidx_blks_icache_hit
from edb$statio_all_tables as e
    ,edb$statio_all_tables as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and e.schemaname in (select distinct schemaname from pg_statio_user_tables)
    order by heap_blks_read desc, relname   
    limit p_topn;
elsif v_stat = 'SYS' then
  open refcur for
select e.schemaname,
	e.relname,
    e.heap_blks_read - b.heap_blks_read  as heap_blks_read,   	 
    e.heap_blks_hit - b.heap_blks_hit  as heap_blks_hit,       
    e.heap_blks_icache_hit - b.heap_blks_icache_hit  as heap_blks_icache_hit,
	coalesce(e.idx_blks_read,0) - coalesce(b.idx_blks_read,0) as idx_blks_read,
	coalesce(e.idx_blks_hit,0) - coalesce(b.idx_blks_hit,0) as idx_blks_hit,
	coalesce(e.idx_blks_icache_hit,0) - coalesce(b.idx_blks_icache_hit,0) as idx_blks_icache_hit,
	coalesce(e.toast_blks_read,0) - coalesce(b.toast_blks_read,0) as toast_blks_read,
	coalesce(e.toast_blks_hit,0) - coalesce(b.toast_blks_hit,0) as toast_blks_hit,
	coalesce(e.toast_blks_icache_hit,0) - coalesce(b.toast_blks_icache_hit,0) as toast_blks_icache_hit,
	coalesce(e.tidx_blks_read,0) - coalesce(b.tidx_blks_read,0) as tidx_blks_read,
 	coalesce(e.tidx_blks_hit,0) - coalesce(b.tidx_blks_hit,0) as tidx_blks_hit,
 	coalesce(e.tidx_blks_icache_hit,0) - coalesce(b.tidx_blks_icache_hit,0) as tidx_blks_icache_hit
from edb$statio_all_tables as e
    ,edb$statio_all_tables as b
where b.edb_id            = p_bid
and e.edb_id              = p_eid
and b.dbname              = e.dbname
and b.schemaname          = e.schemaname
and b.relname		  = e.relname
and e.schemaname in (select distinct schemaname from pg_statio_sys_tables)
    order by heap_blks_read desc, relname   
    limit p_topn;
end if;

loop
fetch refcur into rec;
exit when not found;

textstr := rpad(rec.schemaname,20,' ')||' '||rpad(rec.relname,20,' ')||
' '||rpad(rec.heap_blks_read::text,8,' ') ||' '||rpad(rec.heap_blks_hit::text,8,' ') ||' '||rpad(rec.heap_blks_icache_hit::text,8,' ')||
' '||rpad(rec.idx_blks_read::text,8,' ')  ||' '||rpad(rec.idx_blks_hit::text,8,' ')  ||' '||rpad(rec.idx_blks_icache_hit::text,8,' ')||
' '||rpad(rec.toast_blks_read::text,8,' ')||' '||rpad(rec.toast_blks_hit::text,8,' ')||' '||rpad(rec.toast_blks_icache_hit::text,8,' ')||
' '||rpad(rec.tidx_blks_read::text,8,' ') ||' '||rpad(rec.tidx_blks_hit::text,8,' ') ||' '||rpad(rec.tidx_blks_icache_hit::text,8,' ');
return next textstr;
end loop;

close refcur;
return;
end;
          $_$;


ALTER FUNCTION sys.statio_tables_rpt(p_bid integer, p_eid integer, p_topn integer, p_stat text) OWNER TO rookiextreme;

--
-- Name: sys_rpt(integer, integer, integer); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.sys_rpt(integer, integer, integer) RETURNS SETOF text
    LANGUAGE plpgsql
    AS $_$      

declare
bid     alias for $1;
eid     alias for $2;
topn    alias for $3;

textstr text;
rec RECORD;
begin

textstr := rpad('WAIT NAME',40,' ')||' '||rpad('COUNT',10,' ')||' '||rpad('WAIT TIME',15,' ')||
' '||'% WAIT';
return next textstr;
textstr := '---------------------------------------------------------------------------';
return next textstr;

for rec in (
select e.wait_name,
        abs(e.wait_count - b.wait_count)  as wait_count,   -- sum of all session wait counts
        abs(e.totalwait - b.totalwait)  as totalwait,      -- sum of all session wait times
        round(100* (sumwait/twaits),2) as pctwait     -- divides total waits per event/total of all waits 
                 from  edb$system_waits as b
                    ,  edb$system_waits  as e
    , (select b.wait_name ,sum(abs(e.totalwait - b.totalwait)) as sumwait 
		from edb$system_waits b,
		edb$system_waits e
	where b.edb_id = bid
	and e.edb_id = eid
	and b.wait_name = e.wait_name 
        group by b.wait_name
        ) as sw,           			-- this gets total waits per event for snap period
        (select sum(abs(e.totalwait - b.totalwait)) as twaits 
     		from edb$system_waits b,
			edb$system_waits e
		where b.edb_id = bid
		and e.edb_id = eid
		and b.wait_name = e.wait_name) as tw  -- this gets sum of all waits per snap period
where b.edb_id              = bid
and e.edb_id              = eid
and b.dbname              = e.dbname
and b.wait_name           = e.wait_name
and e.wait_name          = sw.wait_name
and twaits               > 0              -- avoids divide by zero error
    order by pctwait desc, totalwait desc 
    limit topn)  LOOP                               

textstr := rpad(rec.wait_name,40,' ')||' '||rpad(rec.wait_count::text,10,' ')||' '||rpad(rec.totalwait::text,15,' ')||
' '||rec.pctwait;
return next textstr;
end loop;

return;
end;
    $_$;


ALTER FUNCTION sys.sys_rpt(integer, integer, integer) OWNER TO rookiextreme;

--
-- Name: truncsnap(); Type: FUNCTION; Schema: sys; Owner: rookiextreme
--

CREATE FUNCTION sys.truncsnap() RETURNS text
    LANGUAGE plpgsql
    AS $_$ declare
msg text;

begin

truncate table edb$system_waits;
truncate table edb$session_waits;
truncate table edb$session_wait_history;
truncate table edb$snap;
-- added 01/07/2008 - P. Steinheuser
truncate table edb$stat_database;
truncate table edb$stat_all_tables;
truncate table edb$statio_all_tables;
truncate table edb$stat_all_indexes;
truncate table edb$statio_all_indexes;

msg := 'Snapshots truncated.';
return msg;

exception
when others then
msg := 'Function failed.';
return msg;
end;

   $_$;


ALTER FUNCTION sys.truncsnap() OWNER TO rookiextreme;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: dict_bank_competency_types; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_competency_types (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    years_id integer,
    dict_col_competency_types_id integer,
    dict_bank_sets_id integer,
    tech_discipline_flag integer DEFAULT 0,
    flag integer,
    delete_id integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_competency_types OWNER TO rookiextreme;

--
-- Name: dict_bank_competency_types_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_competency_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_competency_types_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_competency_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_competency_types_id_seq OWNED BY public.dict_bank_competency_types.id;


--
-- Name: dict_bank_competency_types_scale_lvls; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_competency_types_scale_lvls (
    id bigint NOT NULL,
    dict_bank_competency_types_id integer NOT NULL,
    dict_bank_scale_lvls_id integer NOT NULL,
    dict_bank_sets_id integer,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_competency_types_scale_lvls OWNER TO rookiextreme;

--
-- Name: dict_bank_competency_types_scale_lvls_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_competency_types_scale_lvls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_competency_types_scale_lvls_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_competency_types_scale_lvls_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_competency_types_scale_lvls_id_seq OWNED BY public.dict_bank_competency_types_scale_lvls.id;


--
-- Name: dict_bank_grades; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_grades (
    id bigint NOT NULL,
    dict_bank_grades_categories_id integer NOT NULL,
    grades_id integer NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_grades OWNER TO rookiextreme;

--
-- Name: dict_bank_grades_categories; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_grades_categories (
    id bigint NOT NULL,
    dict_bank_sets_id integer,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_grades_categories OWNER TO rookiextreme;

--
-- Name: dict_bank_grades_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_grades_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_grades_categories_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_grades_categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_grades_categories_id_seq OWNED BY public.dict_bank_grades_categories.id;


--
-- Name: dict_bank_grades_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_grades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_grades_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_grades_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_grades_id_seq OWNED BY public.dict_bank_grades.id;


--
-- Name: dict_bank_jobgroup_sets; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_jobgroup_sets (
    id bigint NOT NULL,
    jurusan_id text,
    dict_bank_grades_categories_id integer NOT NULL,
    dict_bank_sets_id integer NOT NULL,
    title_eng text NOT NULL,
    title_mal text,
    desc_eng text,
    desc_mal text,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_jobgroup_sets OWNER TO rookiextreme;

--
-- Name: dict_bank_jobgroup_sets_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_jobgroup_sets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_jobgroup_sets_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_jobgroup_sets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_jobgroup_sets_id_seq OWNED BY public.dict_bank_jobgroup_sets.id;


--
-- Name: dict_bank_jobgroup_sets_items; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_jobgroup_sets_items (
    id bigint NOT NULL,
    dict_bank_jobgroup_sets_id integer NOT NULL,
    dict_bank_sets_items_id integer NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_jobgroup_sets_items OWNER TO rookiextreme;

--
-- Name: dict_bank_jobgroup_sets_items_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_jobgroup_sets_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_jobgroup_sets_items_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_jobgroup_sets_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_jobgroup_sets_items_id_seq OWNED BY public.dict_bank_jobgroup_sets_items.id;


--
-- Name: dict_bank_jobgroup_sets_items_scores_sets_grades; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_jobgroup_sets_items_scores_sets_grades (
    id bigint NOT NULL,
    dict_bank_jobgroup_sets_items_id integer NOT NULL,
    dict_bank_grades_id integer NOT NULL,
    dict_bank_jobgroup_sets_id integer NOT NULL,
    score integer NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_jobgroup_sets_items_scores_sets_grades OWNER TO rookiextreme;

--
-- Name: dict_bank_jobgroup_sets_items_scores_sets_grades_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_jobgroup_sets_items_scores_sets_grades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_jobgroup_sets_items_scores_sets_grades_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_jobgroup_sets_items_scores_sets_grades_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_jobgroup_sets_items_scores_sets_grades_id_seq OWNED BY public.dict_bank_jobgroup_sets_items_scores_sets_grades.id;


--
-- Name: dict_bank_measuring_lvls; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_measuring_lvls (
    id bigint NOT NULL,
    dict_col_measuring_lvls_id integer,
    dict_bank_sets_id integer,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_measuring_lvls OWNER TO rookiextreme;

--
-- Name: dict_bank_measuring_lvls_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_measuring_lvls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_measuring_lvls_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_measuring_lvls_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_measuring_lvls_id_seq OWNED BY public.dict_bank_measuring_lvls.id;


--
-- Name: dict_bank_scale_lvls; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_scale_lvls (
    id bigint NOT NULL,
    dict_bank_sets_id integer,
    years_id integer,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_scale_lvls OWNER TO rookiextreme;

--
-- Name: dict_bank_scale_lvls_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_scale_lvls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_scale_lvls_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_scale_lvls_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_scale_lvls_id_seq OWNED BY public.dict_bank_scale_lvls.id;


--
-- Name: dict_bank_scale_lvls_sets; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_scale_lvls_sets (
    id bigint NOT NULL,
    dict_bank_scale_lvls_id integer NOT NULL,
    dict_bank_scale_lvls_skillsets_id integer NOT NULL,
    dict_bank_sets_id integer,
    name text NOT NULL,
    score integer,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_scale_lvls_sets OWNER TO rookiextreme;

--
-- Name: dict_bank_scale_lvls_sets_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_scale_lvls_sets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_scale_lvls_sets_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_scale_lvls_sets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_scale_lvls_sets_id_seq OWNED BY public.dict_bank_scale_lvls_sets.id;


--
-- Name: dict_bank_scale_lvls_skillsets; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_scale_lvls_skillsets (
    id bigint NOT NULL,
    dict_bank_sets_id integer,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_scale_lvls_skillsets OWNER TO rookiextreme;

--
-- Name: dict_bank_scale_lvls_skillsets_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_scale_lvls_skillsets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_scale_lvls_skillsets_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_scale_lvls_skillsets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_scale_lvls_skillsets_id_seq OWNED BY public.dict_bank_scale_lvls_skillsets.id;


--
-- Name: dict_bank_scale_lvls_types; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_scale_lvls_types (
    id bigint NOT NULL,
    dict_bank_sets_id integer,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_scale_lvls_types OWNER TO rookiextreme;

--
-- Name: dict_bank_scale_lvls_types_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_scale_lvls_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_scale_lvls_types_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_scale_lvls_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_scale_lvls_types_id_seq OWNED BY public.dict_bank_scale_lvls_types.id;


--
-- Name: dict_bank_sets; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_sets (
    id bigint NOT NULL,
    profiles_id integer,
    years_id integer NOT NULL,
    title character varying(255) NOT NULL,
    tkh_mula timestamp(0) without time zone NOT NULL,
    tkh_tamat timestamp(0) without time zone NOT NULL,
    flag_publish integer NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    ref_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_sets OWNER TO rookiextreme;

--
-- Name: dict_bank_sets_competencies_questions; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_sets_competencies_questions (
    id bigint NOT NULL,
    dict_bank_sets_items_id integer NOT NULL,
    title_eng text NOT NULL,
    title_mal text,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_sets_competencies_questions OWNER TO rookiextreme;

--
-- Name: dict_bank_sets_competencies_questions_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_sets_competencies_questions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_sets_competencies_questions_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_sets_competencies_questions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_sets_competencies_questions_id_seq OWNED BY public.dict_bank_sets_competencies_questions.id;


--
-- Name: dict_bank_sets_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_sets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_sets_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_sets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_sets_id_seq OWNED BY public.dict_bank_sets.id;


--
-- Name: dict_bank_sets_items; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_sets_items (
    id bigint NOT NULL,
    dict_bank_sets_id integer NOT NULL,
    dict_bank_measuring_lvls_id integer NOT NULL,
    dict_bank_competency_types_scale_lvls_id integer,
    jurusan_id text,
    dict_bank_grades_categories_id integer NOT NULL,
    title_eng text,
    title_mal text,
    flag integer,
    delete_id integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_sets_items OWNER TO rookiextreme;

--
-- Name: dict_bank_sets_items_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_sets_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_sets_items_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_sets_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_sets_items_id_seq OWNED BY public.dict_bank_sets_items.id;


--
-- Name: dict_bank_sets_items_scores_sets_grades; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_bank_sets_items_scores_sets_grades (
    id bigint NOT NULL,
    dict_bank_sets_items_id integer NOT NULL,
    tech_discipline_flag integer DEFAULT 0 NOT NULL,
    dict_bank_grades_id integer NOT NULL,
    score integer,
    flag integer,
    delete_id integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_bank_sets_items_scores_sets_grades OWNER TO rookiextreme;

--
-- Name: dict_bank_sets_items_scores_sets_grades_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_bank_sets_items_scores_sets_grades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_bank_sets_items_scores_sets_grades_id_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_sets_items_scores_sets_grades_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_bank_sets_items_scores_sets_grades_id_seq OWNED BY public.dict_bank_sets_items_scores_sets_grades.id;


--
-- Name: dict_col_competency_types; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_competency_types (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    tech_discipline_flag integer DEFAULT 0,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_competency_types OWNER TO rookiextreme;

--
-- Name: dict_col_competency_types_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_competency_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_competency_types_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_competency_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_competency_types_id_seq OWNED BY public.dict_col_competency_types.id;


--
-- Name: dict_col_competency_types_scale_lvls; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_competency_types_scale_lvls (
    id bigint NOT NULL,
    dict_col_competency_types_id integer NOT NULL,
    dict_col_scale_lvls_id integer NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_competency_types_scale_lvls OWNER TO rookiextreme;

--
-- Name: dict_col_competency_types_scale_lvls_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_competency_types_scale_lvls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_competency_types_scale_lvls_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_competency_types_scale_lvls_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_competency_types_scale_lvls_id_seq OWNED BY public.dict_col_competency_types_scale_lvls.id;


--
-- Name: dict_col_grades; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_grades (
    id bigint NOT NULL,
    dict_col_grades_categories_id integer NOT NULL,
    grades_id integer NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_grades OWNER TO rookiextreme;

--
-- Name: dict_col_grades_categories; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_grades_categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_grades_categories OWNER TO rookiextreme;

--
-- Name: dict_col_grades_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_grades_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_grades_categories_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_grades_categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_grades_categories_id_seq OWNED BY public.dict_col_grades_categories.id;


--
-- Name: dict_col_grades_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_grades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_grades_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_grades_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_grades_id_seq OWNED BY public.dict_col_grades.id;


--
-- Name: dict_col_jobgroup_sets; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_jobgroup_sets (
    id bigint NOT NULL,
    profiles_id integer NOT NULL,
    years_id integer NOT NULL,
    jurusan_id integer NOT NULL,
    dict_col_grades_categories_id integer NOT NULL,
    title_eng text NOT NULL,
    title_mal text NOT NULL,
    desc_eng text NOT NULL,
    desc_mal text NOT NULL,
    ref_id integer NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_jobgroup_sets OWNER TO rookiextreme;

--
-- Name: dict_col_jobgroup_sets_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_jobgroup_sets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_jobgroup_sets_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_jobgroup_sets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_jobgroup_sets_id_seq OWNED BY public.dict_col_jobgroup_sets.id;


--
-- Name: dict_col_jobgroup_sets_items; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_jobgroup_sets_items (
    id bigint NOT NULL,
    dict_col_jobgroup_sets_id integer NOT NULL,
    dict_col_sets_items_id integer NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_jobgroup_sets_items OWNER TO rookiextreme;

--
-- Name: dict_col_jobgroup_sets_items_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_jobgroup_sets_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_jobgroup_sets_items_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_jobgroup_sets_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_jobgroup_sets_items_id_seq OWNED BY public.dict_col_jobgroup_sets_items.id;


--
-- Name: dict_col_measuring_lvls; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_measuring_lvls (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_measuring_lvls OWNER TO rookiextreme;

--
-- Name: dict_col_measuring_lvls_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_measuring_lvls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_measuring_lvls_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_measuring_lvls_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_measuring_lvls_id_seq OWNED BY public.dict_col_measuring_lvls.id;


--
-- Name: dict_col_scale_lvls; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_scale_lvls (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_scale_lvls OWNER TO rookiextreme;

--
-- Name: dict_col_scale_lvls_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_scale_lvls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_scale_lvls_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_scale_lvls_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_scale_lvls_id_seq OWNED BY public.dict_col_scale_lvls.id;


--
-- Name: dict_col_scale_lvls_sets; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_scale_lvls_sets (
    id bigint NOT NULL,
    dict_col_scale_lvls_id integer NOT NULL,
    dict_col_scale_lvls_skillsets_id integer NOT NULL,
    name text NOT NULL,
    score integer NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_scale_lvls_sets OWNER TO rookiextreme;

--
-- Name: dict_col_scale_lvls_sets_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_scale_lvls_sets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_scale_lvls_sets_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_scale_lvls_sets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_scale_lvls_sets_id_seq OWNED BY public.dict_col_scale_lvls_sets.id;


--
-- Name: dict_col_scale_lvls_skillsets; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_scale_lvls_skillsets (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_scale_lvls_skillsets OWNER TO rookiextreme;

--
-- Name: dict_col_scale_lvls_skillsets_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_scale_lvls_skillsets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_scale_lvls_skillsets_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_scale_lvls_skillsets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_scale_lvls_skillsets_id_seq OWNED BY public.dict_col_scale_lvls_skillsets.id;


--
-- Name: dict_col_scale_lvls_types; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_scale_lvls_types (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_scale_lvls_types OWNER TO rookiextreme;

--
-- Name: dict_col_scale_lvls_types_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_scale_lvls_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_scale_lvls_types_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_scale_lvls_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_scale_lvls_types_id_seq OWNED BY public.dict_col_scale_lvls_types.id;


--
-- Name: dict_col_sets_competencies_questions; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_sets_competencies_questions (
    id bigint NOT NULL,
    dict_col_sets_items_id integer NOT NULL,
    title_eng text NOT NULL,
    title_mal text NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_sets_competencies_questions OWNER TO rookiextreme;

--
-- Name: dict_col_sets_competencies_questions_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_sets_competencies_questions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_sets_competencies_questions_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_sets_competencies_questions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_sets_competencies_questions_id_seq OWNED BY public.dict_col_sets_competencies_questions.id;


--
-- Name: dict_col_sets_items; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.dict_col_sets_items (
    id bigint NOT NULL,
    dict_col_measuring_lvls_id integer NOT NULL,
    dict_col_competency_types_scale_lvls_id integer NOT NULL,
    jurusan_id text,
    dict_col_grades_categories_id integer NOT NULL,
    title_eng text NOT NULL,
    title_mal text,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dict_col_sets_items OWNER TO rookiextreme;

--
-- Name: dict_col_sets_items_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.dict_col_sets_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dict_col_sets_items_id_seq OWNER TO rookiextreme;

--
-- Name: dict_col_sets_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.dict_col_sets_items_id_seq OWNED BY public.dict_col_sets_items.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO rookiextreme;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO rookiextreme;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: grades; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.grades (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.grades OWNER TO rookiextreme;

--
-- Name: grades_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.grades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grades_id_seq OWNER TO rookiextreme;

--
-- Name: grades_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.grades_id_seq OWNED BY public.grades.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO rookiextreme;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO rookiextreme;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_resets; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO rookiextreme;

--
-- Name: penilaians_competencies_avgs; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.penilaians_competencies_avgs (
    id integer NOT NULL,
    penilaians_competencies_id integer,
    score integer DEFAULT 0,
    expected integer DEFAULT 0,
    dev_gap character varying(255) DEFAULT 0,
    training character varying(255),
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    dict_bank_sets_items_id integer,
    actual_expected integer,
    actual_dev_gap character varying(255),
    actual_training character varying(255)
);


ALTER TABLE public.penilaians_competencies_avgs OWNER TO rookiextreme;

--
-- Name: penilaian_avg_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.penilaian_avg_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.penilaian_avg_seq OWNER TO rookiextreme;

--
-- Name: penilaian_avg_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.penilaian_avg_seq OWNED BY public.penilaians_competencies_avgs.id;


--
-- Name: penilaians_competencies_penyelia_avgs; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.penilaians_competencies_penyelia_avgs (
    id integer NOT NULL,
    penilaians_competencies_id integer,
    score integer DEFAULT 0,
    expected integer DEFAULT 0,
    dev_gap character varying(255) DEFAULT 0,
    training character varying(255),
    created_at timestamp(6) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(6) without time zone DEFAULT CURRENT_TIMESTAMP,
    dict_bank_sets_items_id integer,
    actual_expected integer,
    actual_dev_gap character varying(255),
    actual_training character varying(255)
);


ALTER TABLE public.penilaians_competencies_penyelia_avgs OWNER TO rookiextreme;

--
-- Name: penilaian_penyelia_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.penilaian_penyelia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.penilaian_penyelia_seq OWNER TO rookiextreme;

--
-- Name: penilaian_penyelia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.penilaian_penyelia_seq OWNED BY public.penilaians_competencies_penyelia_avgs.id;


--
-- Name: penilaians; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.penilaians (
    id bigint NOT NULL,
    profiles_id integer NOT NULL,
    dict_bank_sets_id integer NOT NULL,
    penyelia_profiles_id integer,
    dict_bank_jobgroup_sets_id integer,
    status integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    standard_gred character varying(255),
    actual_gred character varying(255),
    penyelia_update integer DEFAULT 0,
    profiles_cawangans_logs_id integer,
    jurusan_id character varying(255),
    dict_bank_grades_categories_id integer,
    dict_bank_grades_id integer
);


ALTER TABLE public.penilaians OWNER TO rookiextreme;

--
-- Name: penilaians_competencies; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.penilaians_competencies (
    id bigint NOT NULL,
    penilaians_id integer NOT NULL,
    dict_bank_competency_types_scale_lvls_id integer NOT NULL,
    status integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.penilaians_competencies OWNER TO rookiextreme;

--
-- Name: penilaians_competencies_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.penilaians_competencies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.penilaians_competencies_id_seq OWNER TO rookiextreme;

--
-- Name: penilaians_competencies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.penilaians_competencies_id_seq OWNED BY public.penilaians_competencies.id;


--
-- Name: penilaians_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.penilaians_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.penilaians_id_seq OWNER TO rookiextreme;

--
-- Name: penilaians_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.penilaians_id_seq OWNED BY public.penilaians.id;


--
-- Name: penilaians_jawapans; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.penilaians_jawapans (
    id bigint NOT NULL,
    penilaians_competencies_id integer NOT NULL,
    dict_bank_competencies_questions_id integer NOT NULL,
    dict_bank_sets_items_id integer NOT NULL,
    score integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.penilaians_jawapans OWNER TO rookiextreme;

--
-- Name: penilaians_jawapans_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.penilaians_jawapans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.penilaians_jawapans_id_seq OWNER TO rookiextreme;

--
-- Name: penilaians_jawapans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.penilaians_jawapans_id_seq OWNED BY public.penilaians_jawapans.id;


--
-- Name: permission_role; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.permission_role (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);


ALTER TABLE public.permission_role OWNER TO rookiextreme;

--
-- Name: permission_user; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.permission_user (
    permission_id bigint NOT NULL,
    user_id bigint NOT NULL,
    user_type character varying(255) NOT NULL
);


ALTER TABLE public.permission_user OWNER TO rookiextreme;

--
-- Name: permissions; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    display_name character varying(255),
    description character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO rookiextreme;

--
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.permissions_id_seq OWNER TO rookiextreme;

--
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO rookiextreme;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO rookiextreme;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: profiles; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.profiles (
    id bigint NOT NULL,
    users_id integer NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.profiles OWNER TO rookiextreme;

--
-- Name: profiles_alamat_pejabats; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.profiles_alamat_pejabats (
    id bigint NOT NULL,
    profiles_id integer NOT NULL,
    alamat text NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.profiles_alamat_pejabats OWNER TO rookiextreme;

--
-- Name: profiles_alamat_pejabats_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.profiles_alamat_pejabats_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.profiles_alamat_pejabats_id_seq OWNER TO rookiextreme;

--
-- Name: profiles_alamat_pejabats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.profiles_alamat_pejabats_id_seq OWNED BY public.profiles_alamat_pejabats.id;


--
-- Name: profiles_cawangan_logs; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.profiles_cawangan_logs (
    id bigint NOT NULL,
    profiles_id integer NOT NULL,
    neg_perseketuan integer,
    cawangan bigint,
    sektor bigint,
    bahagian bigint,
    unit bigint,
    penempatan bigint,
    cawangan_name character varying(300),
    sektor_name character varying(300),
    bahagian_name character varying(300),
    unit_name character varying(300),
    penempatan_name character varying(300),
    tahun integer,
    flag integer,
    delete_id integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    gred character varying,
    jurusan_id character varying
);


ALTER TABLE public.profiles_cawangan_logs OWNER TO rookiextreme;

--
-- Name: profiles_cawangan_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.profiles_cawangan_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.profiles_cawangan_logs_id_seq OWNER TO rookiextreme;

--
-- Name: profiles_cawangan_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.profiles_cawangan_logs_id_seq OWNED BY public.profiles_cawangan_logs.id;


--
-- Name: profiles_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.profiles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.profiles_id_seq OWNER TO rookiextreme;

--
-- Name: profiles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.profiles_id_seq OWNED BY public.profiles.id;


--
-- Name: profiles_telefons; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.profiles_telefons (
    id bigint NOT NULL,
    profiles_id integer NOT NULL,
    no_tel_pejabat text NOT NULL,
    no_tel_bimbit text NOT NULL,
    flag integer NOT NULL,
    delete_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.profiles_telefons OWNER TO rookiextreme;

--
-- Name: profiles_telefons_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.profiles_telefons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.profiles_telefons_id_seq OWNER TO rookiextreme;

--
-- Name: profiles_telefons_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.profiles_telefons_id_seq OWNED BY public.profiles_telefons.id;


--
-- Name: role_user; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.role_user (
    id bigint NOT NULL,
    role_id bigint NOT NULL,
    user_id bigint NOT NULL,
    user_type character varying(255) NOT NULL
);


ALTER TABLE public.role_user OWNER TO rookiextreme;

--
-- Name: role_user_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.role_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.role_user_id_seq OWNER TO rookiextreme;

--
-- Name: role_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.role_user_id_seq OWNED BY public.role_user.id;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    display_name character varying(255),
    description character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO rookiextreme;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO rookiextreme;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: soalan; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.soalan (
    id integer NOT NULL,
    soalan character varying,
    id_sub_tajuk integer
);


ALTER TABLE public.soalan OWNER TO rookiextreme;

--
-- Name: sub_soalan; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.sub_soalan (
    id integer NOT NULL,
    sub_soalan character varying,
    id_soalan integer
);


ALTER TABLE public.sub_soalan OWNER TO rookiextreme;

--
-- Name: sub_sub_soalan; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.sub_sub_soalan (
    id integer NOT NULL,
    sub_sub_soalan character varying,
    id_sub_soalan integer
);


ALTER TABLE public.sub_sub_soalan OWNER TO rookiextreme;

--
-- Name: sub_tajuk; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.sub_tajuk (
    id integer NOT NULL,
    sub_tajuk character varying,
    id_tajuk integer
);


ALTER TABLE public.sub_tajuk OWNER TO rookiextreme;

--
-- Name: tajuk; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.tajuk (
    id integer NOT NULL,
    "Tajuk" character varying
);


ALTER TABLE public.tajuk OWNER TO rookiextreme;

--
-- Name: users; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    nokp bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO rookiextreme;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO rookiextreme;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: years; Type: TABLE; Schema: public; Owner: rookiextreme
--

CREATE TABLE public.years (
    id bigint NOT NULL,
    year integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.years OWNER TO rookiextreme;

--
-- Name: years_id_seq; Type: SEQUENCE; Schema: public; Owner: rookiextreme
--

CREATE SEQUENCE public.years_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.years_id_seq OWNER TO rookiextreme;

--
-- Name: years_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: rookiextreme
--

ALTER SEQUENCE public.years_id_seq OWNED BY public.years.id;


--
-- Name: edb$session_wait_history; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys."edb$session_wait_history" (
    edb_id bigint NOT NULL,
    dbname name NOT NULL,
    backend_id bigint NOT NULL,
    seq bigint NOT NULL,
    wait_name text,
    elapsed bigint,
    p1 bigint,
    p2 bigint,
    p3 bigint
);


ALTER TABLE sys."edb$session_wait_history" OWNER TO rookiextreme;

--
-- Name: edb$session_waits; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys."edb$session_waits" (
    edb_id bigint NOT NULL,
    dbname name NOT NULL,
    backend_id bigint NOT NULL,
    wait_name text NOT NULL,
    wait_count bigint,
    avg_wait_time numeric,
    max_wait_time numeric(50,6),
    total_wait_time numeric(50,6),
    usename name,
    query text
);


ALTER TABLE sys."edb$session_waits" OWNER TO rookiextreme;

--
-- Name: edb$snap; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys."edb$snap" (
    edb_id bigint NOT NULL,
    dbname name,
    snap_tm timestamp without time zone,
    start_tm timestamp without time zone,
    backend_id bigint,
    comment text,
    baseline_ind character(1)
);


ALTER TABLE sys."edb$snap" OWNER TO rookiextreme;

--
-- Name: edb$stat_all_indexes; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys."edb$stat_all_indexes" (
    edb_id bigint NOT NULL,
    dbname name NOT NULL,
    relid oid NOT NULL,
    indexrelid oid NOT NULL,
    schemaname name,
    relname name,
    indexrelname name,
    idx_scan bigint,
    idx_tup_read bigint,
    idx_tup_fetch bigint
);


ALTER TABLE sys."edb$stat_all_indexes" OWNER TO rookiextreme;

--
-- Name: edb$stat_all_tables; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys."edb$stat_all_tables" (
    edb_id bigint NOT NULL,
    dbname name NOT NULL,
    relid oid NOT NULL,
    schemaname name,
    relname name,
    seq_scan bigint,
    seq_tup_read bigint,
    idx_scan bigint,
    idx_tup_fetch bigint,
    n_tup_ins bigint,
    n_tup_upd bigint,
    n_tup_del bigint,
    last_vacuum timestamp with time zone,
    last_autovacuum timestamp with time zone,
    last_analyze timestamp with time zone,
    last_autoanalyze timestamp with time zone
);


ALTER TABLE sys."edb$stat_all_tables" OWNER TO rookiextreme;

--
-- Name: edb$stat_database; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys."edb$stat_database" (
    edb_id bigint NOT NULL,
    dbname name NOT NULL,
    datid oid NOT NULL,
    datname name,
    numbackends integer,
    xact_commit bigint,
    xact_rollback bigint,
    blks_read bigint,
    blks_hit bigint,
    blks_icache_hit bigint
);


ALTER TABLE sys."edb$stat_database" OWNER TO rookiextreme;

--
-- Name: edb$statio_all_indexes; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys."edb$statio_all_indexes" (
    edb_id bigint NOT NULL,
    dbname name NOT NULL,
    relid oid NOT NULL,
    indexrelid oid NOT NULL,
    schemaname name,
    relname name,
    indexrelname name,
    idx_blks_read bigint,
    idx_blks_hit bigint,
    idx_blks_icache_hit bigint
);


ALTER TABLE sys."edb$statio_all_indexes" OWNER TO rookiextreme;

--
-- Name: edb$statio_all_tables; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys."edb$statio_all_tables" (
    edb_id bigint NOT NULL,
    dbname name NOT NULL,
    relid oid NOT NULL,
    schemaname name,
    relname name,
    heap_blks_read bigint,
    heap_blks_hit bigint,
    heap_blks_icache_hit bigint,
    idx_blks_read bigint,
    idx_blks_hit bigint,
    idx_blks_icache_hit bigint,
    toast_blks_read bigint,
    toast_blks_hit bigint,
    toast_blks_icache_hit bigint,
    tidx_blks_read bigint,
    tidx_blks_hit bigint,
    tidx_blks_icache_hit bigint
);


ALTER TABLE sys."edb$statio_all_tables" OWNER TO rookiextreme;

--
-- Name: edb$system_waits; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys."edb$system_waits" (
    edb_id bigint NOT NULL,
    dbname name NOT NULL,
    wait_name text NOT NULL,
    wait_count bigint,
    avg_wait numeric,
    max_wait numeric(50,6),
    totalwait numeric(50,6)
);


ALTER TABLE sys."edb$system_waits" OWNER TO rookiextreme;

--
-- Name: plsql_profiler_rawdata; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys.plsql_profiler_rawdata (
    runid integer,
    sourcecode text,
    func_oid oid,
    line_number integer,
    exec_count bigint,
    tuples_returned bigint,
    time_total double precision,
    time_shortest double precision,
    time_longest double precision,
    num_scans bigint,
    tuples_fetched bigint,
    tuples_inserted bigint,
    tuples_updated bigint,
    tuples_deleted bigint,
    blocks_fetched bigint,
    blocks_hit bigint,
    wal_write bigint,
    wal_flush bigint,
    wal_file_sync bigint,
    buffer_free_list_lock_acquire bigint,
    shmem_index_lock_acquire bigint,
    oid_gen_lock_acquire bigint,
    xid_gen_lock_acquire bigint,
    proc_array_lock_acquire bigint,
    sinval_lock_acquire bigint,
    freespace_lock_acquire bigint,
    wal_insert_lock_acquire bigint,
    wal_write_lock_acquire bigint,
    control_file_lock_acquire bigint,
    checkpoint_lock_acquire bigint,
    clog_control_lock_acquire bigint,
    subtrans_control_lock_acquire bigint,
    multi_xact_gen_lock_acquire bigint,
    multi_xact_offset_lock_acquire bigint,
    multi_xact_member_lock_acquire bigint,
    rel_cache_init_lock_acquire bigint,
    bgwriter_communication_lock_acquire bigint,
    two_phase_state_lock_acquire bigint,
    tablespace_create_lock_acquire bigint,
    btree_vacuum_lock_acquire bigint,
    add_in_shmem_lock_acquire bigint,
    autovacuum_lock_acquire bigint,
    autovacuum_schedule_lock_acquire bigint,
    syncscan_lock_acquire bigint,
    icache_lock_acquire bigint,
    breakpoint_lock_acquire bigint,
    lwlock_acquire bigint,
    db_file_read bigint,
    db_file_write bigint,
    db_file_sync bigint,
    db_file_extend bigint,
    sql_parse bigint,
    query_plan bigint,
    infinitecache_read bigint,
    infinitecache_write bigint,
    wal_write_time bigint,
    wal_flush_time bigint,
    wal_file_sync_time bigint,
    buffer_free_list_lock_acquire_time bigint,
    shmem_index_lock_acquire_time bigint,
    oid_gen_lock_acquire_time bigint,
    xid_gen_lock_acquire_time bigint,
    proc_array_lock_acquire_time bigint,
    sinval_lock_acquire_time bigint,
    freespace_lock_acquire_time bigint,
    wal_insert_lock_acquire_time bigint,
    wal_write_lock_acquire_time bigint,
    control_file_lock_acquire_time bigint,
    checkpoint_lock_acquire_time bigint,
    clog_control_lock_acquire_time bigint,
    subtrans_control_lock_acquire_time bigint,
    multi_xact_gen_lock_acquire_time bigint,
    multi_xact_offset_lock_acquire_time bigint,
    multi_xact_member_lock_acquire_time bigint,
    rel_cache_init_lock_acquire_time bigint,
    bgwriter_communication_lock_acquire_time bigint,
    two_phase_state_lock_acquire_time bigint,
    tablespace_create_lock_acquire_time bigint,
    btree_vacuum_lock_acquire_time bigint,
    add_in_shmem_lock_acquire_time bigint,
    autovacuum_lock_acquire_time bigint,
    autovacuum_schedule_lock_acquire_time bigint,
    syncscan_lock_acquire_time bigint,
    icache_lock_acquire_time bigint,
    breakpoint_lock_acquire_time bigint,
    lwlock_acquire_time bigint,
    db_file_read_time bigint,
    db_file_write_time bigint,
    db_file_sync_time bigint,
    db_file_extend_time bigint,
    sql_parse_time bigint,
    query_plan_time bigint,
    infinitecache_read_time bigint,
    infinitecache_write_time bigint,
    totalwaits bigint,
    totalwaittime bigint
);


ALTER TABLE sys.plsql_profiler_rawdata OWNER TO rookiextreme;

--
-- Name: plsql_profiler_runid; Type: SEQUENCE; Schema: sys; Owner: rookiextreme
--

CREATE SEQUENCE sys.plsql_profiler_runid
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sys.plsql_profiler_runid OWNER TO rookiextreme;

--
-- Name: plsql_profiler_runs; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys.plsql_profiler_runs (
    runid integer NOT NULL,
    related_run integer,
    run_owner text,
    run_date timestamp without time zone,
    run_comment text,
    run_total_time bigint,
    run_system_info text,
    run_comment1 text,
    spare1 text
);


ALTER TABLE sys.plsql_profiler_runs OWNER TO rookiextreme;

--
-- Name: plsql_profiler_units; Type: TABLE; Schema: sys; Owner: rookiextreme
--

CREATE TABLE sys.plsql_profiler_units (
    runid integer,
    unit_number oid,
    unit_type text,
    unit_owner text,
    unit_name text,
    unit_timestamp timestamp without time zone,
    total_time bigint,
    spare1 bigint,
    spare2 bigint
);


ALTER TABLE sys.plsql_profiler_units OWNER TO rookiextreme;

--
-- Name: snapshot_num_seq; Type: SEQUENCE; Schema: sys; Owner: rookiextreme
--

CREATE SEQUENCE sys.snapshot_num_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sys.snapshot_num_seq OWNER TO rookiextreme;

--
-- Name: dict_bank_competency_types id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_competency_types ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_competency_types_id_seq'::regclass);


--
-- Name: dict_bank_competency_types_scale_lvls id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_competency_types_scale_lvls ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_competency_types_scale_lvls_id_seq'::regclass);


--
-- Name: dict_bank_grades id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_grades ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_grades_id_seq'::regclass);


--
-- Name: dict_bank_grades_categories id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_grades_categories ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_grades_categories_id_seq'::regclass);


--
-- Name: dict_bank_jobgroup_sets id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_jobgroup_sets_id_seq'::regclass);


--
-- Name: dict_bank_jobgroup_sets_items id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets_items ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_jobgroup_sets_items_id_seq'::regclass);


--
-- Name: dict_bank_jobgroup_sets_items_scores_sets_grades id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets_items_scores_sets_grades ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_jobgroup_sets_items_scores_sets_grades_id_seq'::regclass);


--
-- Name: dict_bank_measuring_lvls id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_measuring_lvls ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_measuring_lvls_id_seq'::regclass);


--
-- Name: dict_bank_scale_lvls id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_scale_lvls_id_seq'::regclass);


--
-- Name: dict_bank_scale_lvls_sets id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls_sets ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_scale_lvls_sets_id_seq'::regclass);


--
-- Name: dict_bank_scale_lvls_skillsets id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls_skillsets ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_scale_lvls_skillsets_id_seq'::regclass);


--
-- Name: dict_bank_scale_lvls_types id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls_types ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_scale_lvls_types_id_seq'::regclass);


--
-- Name: dict_bank_sets id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_sets_id_seq'::regclass);


--
-- Name: dict_bank_sets_competencies_questions id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_competencies_questions ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_sets_competencies_questions_id_seq'::regclass);


--
-- Name: dict_bank_sets_items id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_items ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_sets_items_id_seq'::regclass);


--
-- Name: dict_bank_sets_items_scores_sets_grades id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_items_scores_sets_grades ALTER COLUMN id SET DEFAULT nextval('public.dict_bank_sets_items_scores_sets_grades_id_seq'::regclass);


--
-- Name: dict_col_competency_types id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_competency_types ALTER COLUMN id SET DEFAULT nextval('public.dict_col_competency_types_id_seq'::regclass);


--
-- Name: dict_col_competency_types_scale_lvls id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_competency_types_scale_lvls ALTER COLUMN id SET DEFAULT nextval('public.dict_col_competency_types_scale_lvls_id_seq'::regclass);


--
-- Name: dict_col_grades id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_grades ALTER COLUMN id SET DEFAULT nextval('public.dict_col_grades_id_seq'::regclass);


--
-- Name: dict_col_grades_categories id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_grades_categories ALTER COLUMN id SET DEFAULT nextval('public.dict_col_grades_categories_id_seq'::regclass);


--
-- Name: dict_col_jobgroup_sets id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_jobgroup_sets ALTER COLUMN id SET DEFAULT nextval('public.dict_col_jobgroup_sets_id_seq'::regclass);


--
-- Name: dict_col_jobgroup_sets_items id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_jobgroup_sets_items ALTER COLUMN id SET DEFAULT nextval('public.dict_col_jobgroup_sets_items_id_seq'::regclass);


--
-- Name: dict_col_measuring_lvls id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_measuring_lvls ALTER COLUMN id SET DEFAULT nextval('public.dict_col_measuring_lvls_id_seq'::regclass);


--
-- Name: dict_col_scale_lvls id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_scale_lvls ALTER COLUMN id SET DEFAULT nextval('public.dict_col_scale_lvls_id_seq'::regclass);


--
-- Name: dict_col_scale_lvls_sets id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_scale_lvls_sets ALTER COLUMN id SET DEFAULT nextval('public.dict_col_scale_lvls_sets_id_seq'::regclass);


--
-- Name: dict_col_scale_lvls_skillsets id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_scale_lvls_skillsets ALTER COLUMN id SET DEFAULT nextval('public.dict_col_scale_lvls_skillsets_id_seq'::regclass);


--
-- Name: dict_col_scale_lvls_types id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_scale_lvls_types ALTER COLUMN id SET DEFAULT nextval('public.dict_col_scale_lvls_types_id_seq'::regclass);


--
-- Name: dict_col_sets_competencies_questions id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_sets_competencies_questions ALTER COLUMN id SET DEFAULT nextval('public.dict_col_sets_competencies_questions_id_seq'::regclass);


--
-- Name: dict_col_sets_items id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_sets_items ALTER COLUMN id SET DEFAULT nextval('public.dict_col_sets_items_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: grades id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.grades ALTER COLUMN id SET DEFAULT nextval('public.grades_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: penilaians id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians ALTER COLUMN id SET DEFAULT nextval('public.penilaians_id_seq'::regclass);


--
-- Name: penilaians_competencies id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies ALTER COLUMN id SET DEFAULT nextval('public.penilaians_competencies_id_seq'::regclass);


--
-- Name: penilaians_competencies_avgs id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies_avgs ALTER COLUMN id SET DEFAULT nextval('public.penilaian_avg_seq'::regclass);


--
-- Name: penilaians_competencies_penyelia_avgs id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies_penyelia_avgs ALTER COLUMN id SET DEFAULT nextval('public.penilaian_penyelia_seq'::regclass);


--
-- Name: penilaians_jawapans id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_jawapans ALTER COLUMN id SET DEFAULT nextval('public.penilaians_jawapans_id_seq'::regclass);


--
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: profiles id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles ALTER COLUMN id SET DEFAULT nextval('public.profiles_id_seq'::regclass);


--
-- Name: profiles_alamat_pejabats id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles_alamat_pejabats ALTER COLUMN id SET DEFAULT nextval('public.profiles_alamat_pejabats_id_seq'::regclass);


--
-- Name: profiles_cawangan_logs id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles_cawangan_logs ALTER COLUMN id SET DEFAULT nextval('public.profiles_cawangan_logs_id_seq'::regclass);


--
-- Name: profiles_telefons id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles_telefons ALTER COLUMN id SET DEFAULT nextval('public.profiles_telefons_id_seq'::regclass);


--
-- Name: role_user id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.role_user ALTER COLUMN id SET DEFAULT nextval('public.role_user_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: years id; Type: DEFAULT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.years ALTER COLUMN id SET DEFAULT nextval('public.years_id_seq'::regclass);


--
-- Data for Name: dict_bank_competency_types; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_competency_types (id, name, years_id, dict_col_competency_types_id, dict_bank_sets_id, tech_discipline_flag, flag, delete_id, created_at, updated_at) FROM stdin;
6	Technical (Discipline)	\N	\N	1	0	1	0	2021-11-25 03:50:15	2021-11-25 03:50:15
7	Technical (Generic)	\N	\N	1	0	1	0	2021-11-25 03:50:20	2021-11-25 03:50:20
8	888	\N	\N	1	0	1	1	2021-12-02 03:24:33	2021-12-02 03:24:38
2	Functional	\N	\N	1	0	1	0	2021-11-25 03:49:40	2021-12-15 04:00:54
1	Behavioural	\N	\N	1	0	1	0	2021-11-25 03:48:52	2021-12-15 04:00:56
9	A1	\N	\N	2	0	1	0	2021-12-16 01:19:04	2021-12-16 01:19:04
10	B2	\N	\N	2	0	1	0	2021-12-16 01:19:18	2021-12-16 01:19:18
11	C3	\N	\N	2	0	1	0	2021-12-16 01:19:28	2021-12-16 01:19:28
12	D4	\N	\N	2	0	1	0	2021-12-16 01:19:37	2021-12-16 01:19:37
13	J41	\N	\N	3	0	1	0	2021-12-16 01:27:02	2021-12-16 01:27:02
14	J44	\N	\N	3	0	1	0	2021-12-16 01:27:14	2021-12-16 01:27:14
15	ICT System	\N	\N	3	0	1	0	2021-12-16 03:12:54	2021-12-16 03:12:54
16	Electrical Proctection System	\N	\N	4	0	1	0	2021-12-16 03:13:25	2021-12-16 03:13:25
17	Building Survey	\N	\N	4	0	1	0	2021-12-16 03:42:29	2021-12-16 03:42:29
3	Generic	\N	\N	1	0	1	0	2021-11-25 03:49:50	2022-01-17 16:28:09
4	ICT	\N	\N	1	0	1	0	2021-11-25 03:50:00	2022-01-17 16:28:10
5	Language	\N	\N	1	0	1	0	2021-11-25 03:50:07	2022-01-17 16:28:11
18	Behavioural	\N	\N	7	0	1	0	2022-02-19 23:13:30	2022-02-19 23:13:30
19	Functional	\N	\N	7	0	1	0	2022-02-19 23:13:35	2022-02-19 23:13:35
\.


--
-- Data for Name: dict_bank_competency_types_scale_lvls; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_competency_types_scale_lvls (id, dict_bank_competency_types_id, dict_bank_scale_lvls_id, dict_bank_sets_id, flag, delete_id, created_at, updated_at) FROM stdin;
2	2	2	1	1	0	2021-11-25 04:05:55	2021-11-25 04:05:55
3	3	2	1	1	0	2021-11-25 04:06:03	2021-11-25 04:06:03
4	4	4	1	1	0	2021-11-25 04:06:10	2021-11-25 04:06:10
5	5	1	1	1	0	2021-11-25 04:06:22	2021-11-25 04:06:22
6	6	2	1	1	0	2021-11-25 04:06:28	2021-11-25 04:06:28
7	7	2	1	1	0	2021-11-25 04:06:33	2021-11-25 04:06:33
1	1	3	1	1	0	2021-11-25 04:05:47	2021-12-07 04:00:29
8	16	6	4	1	0	2021-12-16 03:17:46	2021-12-16 03:17:46
9	17	7	4	1	0	2021-12-16 03:45:21	2021-12-16 03:45:21
10	18	8	7	1	0	2022-02-19 23:35:00	2022-02-19 23:35:00
11	19	9	7	1	0	2022-02-19 23:35:06	2022-02-19 23:35:06
\.


--
-- Data for Name: dict_bank_grades; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_grades (id, dict_bank_grades_categories_id, grades_id, flag, delete_id, created_at, updated_at) FROM stdin;
1	1	10	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
2	1	11	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
3	1	12	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
4	1	13	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
5	1	14	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
6	1	15	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
7	1	16	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
8	1	17	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
9	1	18	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
10	1	19	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
11	1	20	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
12	1	21	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
13	1	22	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
14	1	23	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
15	1	24	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
16	2	1	1	0	2021-11-25 04:11:45	2021-11-25 04:11:45
17	2	2	1	0	2021-11-25 04:11:45	2021-11-25 04:11:45
18	2	3	1	0	2021-11-25 04:11:45	2021-11-25 04:11:45
19	2	4	1	0	2021-11-25 04:11:45	2021-11-25 04:11:45
20	2	5	1	0	2021-11-25 04:11:45	2021-11-25 04:11:45
21	2	6	1	0	2021-11-25 04:11:45	2021-11-25 04:11:45
22	2	7	1	0	2021-11-25 04:11:45	2021-11-25 04:11:45
23	2	8	1	0	2021-11-25 04:11:45	2021-11-25 04:11:45
24	2	9	1	0	2021-11-25 04:11:45	2021-11-25 04:11:45
25	3	20	1	0	2021-12-16 03:15:54	2021-12-16 03:15:54
26	3	22	1	0	2021-12-16 03:15:54	2021-12-16 03:15:54
27	3	24	1	0	2021-12-16 03:15:54	2021-12-16 03:15:54
28	4	4	1	0	2021-12-16 03:43:38	2021-12-16 03:43:38
29	4	5	1	0	2021-12-16 03:43:38	2021-12-16 03:43:38
30	4	24	1	0	2021-12-16 03:43:38	2021-12-16 03:43:38
31	5	1	1	0	2022-02-19 23:23:02	2022-02-19 23:23:02
32	5	2	1	0	2022-02-19 23:23:02	2022-02-19 23:23:02
33	5	5	1	0	2022-02-19 23:23:02	2022-02-19 23:23:02
34	5	6	1	0	2022-02-19 23:23:02	2022-02-19 23:23:02
35	5	8	1	0	2022-02-19 23:38:00	2022-02-19 23:38:00
\.


--
-- Data for Name: dict_bank_grades_categories; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_grades_categories (id, dict_bank_sets_id, name, flag, delete_id, created_at, updated_at) FROM stdin;
1	1	Kumpulan Pelaksana	1	0	2021-11-25 04:10:17	2021-11-25 04:10:17
2	1	Pengurusan dan Profesional	1	0	2021-11-25 04:11:45	2021-11-25 04:21:17
3	4	AB	1	0	2021-12-16 03:15:54	2021-12-16 03:15:54
4	4	jkr	1	0	2021-12-16 03:43:38	2021-12-16 03:43:38
5	7	Test A	1	0	2022-02-19 23:23:02	2022-02-19 23:23:02
\.


--
-- Data for Name: dict_bank_jobgroup_sets; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_jobgroup_sets (id, jurusan_id, dict_bank_grades_categories_id, dict_bank_sets_id, title_eng, title_mal, desc_eng, desc_mal, flag, delete_id, created_at, updated_at) FROM stdin;
177	E	2	1	test Job Group	\N	\N	\N	1	0	2022-02-20 14:29:33	2022-02-20 14:29:33
\.


--
-- Data for Name: dict_bank_jobgroup_sets_items; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_jobgroup_sets_items (id, dict_bank_jobgroup_sets_id, dict_bank_sets_items_id, flag, delete_id, created_at, updated_at) FROM stdin;
2365	177	320	1	0	2022-02-20 14:29:33	2022-02-20 14:29:33
\.


--
-- Data for Name: dict_bank_jobgroup_sets_items_scores_sets_grades; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_jobgroup_sets_items_scores_sets_grades (id, dict_bank_jobgroup_sets_items_id, dict_bank_grades_id, dict_bank_jobgroup_sets_id, score, flag, delete_id, created_at, updated_at) FROM stdin;
24999	2365	16	177	9	1	0	2022-02-20 14:29:36	2022-02-20 14:29:41
25000	2365	17	177	9	1	0	2022-02-20 14:29:36	2022-02-20 14:29:41
25001	2365	18	177	9	1	0	2022-02-20 14:29:36	2022-02-20 14:29:41
25002	2365	19	177	9	1	0	2022-02-20 14:29:36	2022-02-20 14:29:41
25003	2365	20	177	9	1	0	2022-02-20 14:29:36	2022-02-20 14:29:41
25004	2365	21	177	9	1	0	2022-02-20 14:29:36	2022-02-20 14:29:41
25005	2365	22	177	9	1	0	2022-02-20 14:29:36	2022-02-20 14:29:41
25006	2365	23	177	9	1	0	2022-02-20 14:29:36	2022-02-20 14:29:41
25007	2365	24	177	9	1	0	2022-02-20 14:29:36	2022-02-20 14:29:41
\.


--
-- Data for Name: dict_bank_measuring_lvls; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_measuring_lvls (id, dict_col_measuring_lvls_id, dict_bank_sets_id, name, flag, delete_id, created_at, updated_at) FROM stdin;
1	\N	1	Personal Effectiveness	1	0	2021-11-25 04:00:34	2021-11-25 04:00:34
2	\N	1	Technical Mastery	1	0	2021-11-25 04:00:42	2021-11-25 04:00:42
3	\N	1	Keberkesanan Korporat	1	0	2021-11-25 04:00:48	2021-11-25 04:00:48
4	\N	1	Keberkesanan Kepimpinan	1	0	2021-11-25 04:00:56	2021-11-25 04:00:56
5	\N	1	Keberkesanan Sahsiah	1	0	2021-11-25 04:01:05	2021-11-25 04:01:05
6	\N	1	Kepakaran Teknikal	1	0	2021-11-25 04:01:22	2021-11-25 04:01:22
7	\N	1	Corporate Effectiveness	1	0	2021-11-25 04:01:30	2021-11-25 04:01:30
8	\N	1	Leadership Effectiveness	1	0	2021-11-25 04:01:51	2021-11-25 04:01:51
9	\N	3	J41	1	0	2021-12-16 01:27:36	2021-12-16 01:27:36
10	\N	4	Personal Effectiveness 1	1	0	2021-12-16 03:15:17	2021-12-16 03:15:17
11	\N	4	Technical Mastery 1	1	0	2021-12-16 03:43:01	2021-12-16 03:43:01
12	\N	7	CORPORATE EFFECTIVENESS	1	0	2022-02-19 23:22:32	2022-02-19 23:22:32
\.


--
-- Data for Name: dict_bank_scale_lvls; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_scale_lvls (id, dict_bank_sets_id, years_id, name, flag, delete_id, created_at, updated_at) FROM stdin;
1	1	\N	Scale Language	1	0	2021-11-25 03:46:11	2021-11-25 03:46:11
2	1	\N	1-6	1	0	2021-11-25 03:46:29	2021-11-25 03:46:29
3	1	\N	Yes/No	1	0	2021-11-25 03:46:41	2021-11-25 03:46:41
4	1	\N	Scale ICT	1	0	2021-11-25 03:47:05	2021-11-25 03:47:05
5	1	\N	999999	1	1	2021-12-02 03:25:07	2021-12-02 03:25:10
6	4	\N	TeST 1-6	1	0	2021-12-16 03:16:35	2021-12-16 03:16:35
7	4	\N	cubaan	1	0	2021-12-16 03:44:11	2021-12-16 03:44:11
8	7	\N	Yes/No	1	0	2022-02-19 23:24:29	2022-02-19 23:24:29
9	7	\N	Scaling Test	1	0	2022-02-19 23:24:49	2022-02-19 23:24:49
\.


--
-- Data for Name: dict_bank_scale_lvls_sets; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_scale_lvls_sets (id, dict_bank_scale_lvls_id, dict_bank_scale_lvls_skillsets_id, dict_bank_sets_id, name, score, flag, delete_id, created_at, updated_at) FROM stdin;
1	2	5	\N	YOU ARE ABLE TO DIRECTLY APPLY TECHNIQUES AND USE TOOLS/EQUIPMENT INDEPENDENTLY. SUPERVISION IS NECESSARY FROM TIME TO TIME. YOU ARE ABLE TO DIAGNOSE ISSUES, ANTICIPATE PROBLEMS AND PROVIDE REASONING. YOU WORK WITH PRACTISIONERS IN A SPECIFIC SKILL AREA	0	1	0	2021-11-25 08:03:49	2021-11-25 08:03:49
2	2	6	\N	YOU ARE A SOURCE OR REFERENCE TO OTHERS WHO SEEK ADVICE IN A PARTICULAR AREA/FIELD. YOU ARE ABLE TO DEVELOP AND MENTOR OTHERS IN TECHNIQUE, PROCEDURE OR PROCESS. ABLE TO CREATE BEST PRACTICE IN THE ORGANISATION OR IN A BROADER CONTEXT.	0	1	0	2021-11-25 08:04:00	2021-11-25 08:04:00
3	2	7	\N	YOU ARE NOT TRAINED AND HAVE NO EXPERIENCE	0	1	0	2021-11-25 08:04:12	2021-11-25 08:04:12
4	2	8	\N	YOU ARE STILL LEARNING AND HAVE HAD SOME PRIOR EXPOSURE OR HAVE BASIC KNOWLEDGE OR HAVE HAD SOME PRACTICE. YOU ARE ABLE TO ANALYSE AND INTERPRET INFORMATION. SUPERVISION IS NEEDED. YOU KNOW WHERE TO OBTAIN HELP	0	1	0	2021-11-25 08:04:21	2021-11-25 08:04:21
5	4	8	\N	BASIC KNOWLEDGE OF SOFTWARE APPLICATIONS; MAY UNDERSTAND AND/OR APPLY SOME PARTS OF THE SOFTWARE APPLICATIONS.	0	1	0	2021-11-25 08:05:58	2021-11-25 08:05:58
6	4	9	\N	CAN UNDERSTAND & APPLY SOFTWARE APPLICATIONS WELL	0	1	0	2021-11-25 08:06:08	2021-11-25 08:06:08
7	4	11	\N	HIGH PROFICIENCY IN UNDERSTANDING, APPLYING & TEACHING OF SOFTWARE APPLICATIONS	0	1	0	2021-11-25 08:07:52	2021-11-25 08:07:52
8	4	12	\N	NO KNOWLEDGE OF THE SOFTWARE APPLICATIONS	0	1	0	2021-11-25 08:07:59	2021-11-25 08:07:59
9	1	9	\N	ABLE TO READ AND WRITE FLUENTLY AND ACCURATELY IN ALL STYLES AND FORMS OF THE LANGUAGE ON ANY SUBJECT AS WELL AS THOSE PERTINENT TO PROFESSIONAL NEEDS	0	1	0	2021-11-25 08:08:40	2021-11-25 08:08:40
10	1	8	\N	ABLE TO READ AND WRITE REASONABLY WELL AND APPRECIATE A WIDE VARIETY OF TEXTS AS WELL AS THOSE PRETINENT TO PROFESSIONAL NEEDS	0	1	0	2021-11-25 08:08:47	2021-11-25 08:08:47
11	1	11	\N	HAVE MASTERY OF THE LANGUAGEL; NEAR NATIVE; ABILITY TO READ, UNDERSTAND AND WRITE EXTREMLY DIFFICULT OF ABSTRACT PROSE, A WIDE VARIETY OF VOCABULARY, IDIOMS COLLOQUIALISMS, AND SLANG	0	1	0	2021-11-25 08:08:55	2021-11-25 08:08:55
12	1	13	\N	POOR COMMAND OF THE LANGUAGE	0	1	0	2021-11-25 08:09:03	2021-11-25 08:09:03
13	2	9	\N	YOU HAVE SUBSTANTIAL EXPERIENCE AND ARE ABLE TO SUPERVISE OTHERS. YOU DEMONSTRATE THIS SKILL INDEPENDENTLY ALMOST ALL THE TIME. YOU ARE ABLE TO DIAGNOSE ISSUES, ANTICIPATE PROBLEMS AND PROVIDE REASONING. YOU WORK WITH PRACTICITONERS IN A SPECIFIC SKILL AREA.	0	1	0	2021-11-26 07:05:43	2021-11-26 07:05:43
14	2	10	\N	YOU HAVE THE SKILLS TO SET POLICIES AND PROVIDE OVERALL DIRECTION.	0	1	0	2021-11-26 07:06:50	2021-11-26 07:06:50
15	6	8	\N	basic	1	1	0	2021-12-16 03:16:58	2021-12-16 03:16:58
16	7	12	\N	1	1	1	0	2021-12-16 03:44:44	2021-12-16 03:44:44
17	7	8	\N	2	2	1	0	2021-12-16 03:44:55	2021-12-16 03:44:55
18	9	15	\N	Scale one	0	1	0	2022-02-19 23:34:23	2022-02-19 23:34:23
19	9	16	\N	Scale Two	0	1	0	2022-02-19 23:34:31	2022-02-19 23:34:31
\.


--
-- Data for Name: dict_bank_scale_lvls_skillsets; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_scale_lvls_skillsets (id, dict_bank_sets_id, name, flag, delete_id, created_at, updated_at) FROM stdin;
2	1	1-6	1	1	2021-11-25 03:59:31	2021-11-25 08:02:09
3	1	Scale ICT	1	1	2021-11-25 03:59:51	2021-11-25 08:02:12
4	1	Scale Language	1	1	2021-11-25 04:00:00	2021-11-25 08:02:14
1	1	Yes/No	1	1	2021-11-25 03:59:17	2021-11-25 08:02:16
6	1	EXPERT	1	0	2021-11-25 08:02:37	2021-11-25 08:02:37
9	1	PROFICIENT	1	0	2021-11-25 08:02:53	2021-11-25 08:02:53
10	1	STRATEGIES	1	0	2021-11-25 08:02:57	2021-11-25 08:02:57
11	1	MASTERY	1	0	2021-11-25 08:06:38	2021-11-25 08:06:38
12	1	NONE	1	0	2021-11-25 08:06:42	2021-11-25 08:06:42
13	1	POOR	1	0	2021-11-25 08:08:23	2021-11-25 08:08:23
8	1	BASIC	1	0	2021-11-25 08:02:47	2021-12-15 04:01:00
5	1	COMPETENT	1	0	2021-11-25 08:02:32	2021-12-15 04:01:01
7	1	ENTRY	1	0	2021-11-25 08:02:42	2021-12-15 04:01:01
14	7	Poor	1	0	2022-02-19 23:22:03	2022-02-19 23:22:03
15	7	ENTRY	1	0	2022-02-19 23:22:15	2022-02-19 23:22:15
16	7	Saja Test	1	0	2022-02-19 23:30:39	2022-02-19 23:30:39
\.


--
-- Data for Name: dict_bank_scale_lvls_types; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_scale_lvls_types (id, dict_bank_sets_id, name, flag, delete_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: dict_bank_sets; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_sets (id, profiles_id, years_id, title, tkh_mula, tkh_tamat, flag_publish, flag, delete_id, ref_id, created_at, updated_at) FROM stdin;
5	\N	1	PERCUBAAN 2022	2022-01-17 09:40:00	2022-01-17 12:00:00	0	1	1	0	2022-01-17 09:36:32	2022-01-17 16:32:20
4	\N	1	Contoh Penilaian 1	2021-12-17 08:00:00	2021-12-21 17:00:00	0	1	1	0	2021-12-16 03:10:18	2022-01-17 16:32:23
3	\N	1	testing  1	2021-12-16 12:00:00	2021-12-31 12:00:00	0	1	1	0	2021-12-16 01:26:40	2022-01-17 16:32:27
2	\N	1	UAT 16122021	2021-12-16 12:00:00	2021-12-17 12:00:00	0	1	1	0	2021-12-16 01:17:55	2022-01-17 16:32:30
6	\N	1	testtt	2022-02-09 12:00:00	2022-07-22 12:00:00	0	1	1	0	2022-02-08 14:53:11	2022-02-19 23:11:57
1	\N	1	Cubaan 2021	2021-12-01 09:00:00	2022-12-08 12:00:00	1	1	0	0	2021-11-25 02:45:02	2022-01-17 11:55:08
7	\N	1	Meor Test	2022-02-02 12:00:00	2022-04-19 12:00:00	0	1	0	0	2022-02-19 23:13:01	2022-02-19 23:39:28
\.


--
-- Data for Name: dict_bank_sets_competencies_questions; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_sets_competencies_questions (id, dict_bank_sets_items_id, title_eng, title_mal, flag, delete_id, created_at, updated_at) FROM stdin;
429	320	Awesome	\N	1	1	2022-02-20 14:20:50	2022-02-20 14:21:06
430	320	Awesome	\N	1	0	2022-02-20 14:21:10	2022-02-20 14:21:10
431	321	Test 1	\N	1	0	2022-02-20 14:35:48	2022-02-20 14:35:48
\.


--
-- Data for Name: dict_bank_sets_items; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_sets_items (id, dict_bank_sets_id, dict_bank_measuring_lvls_id, dict_bank_competency_types_scale_lvls_id, jurusan_id, dict_bank_grades_categories_id, title_eng, title_mal, flag, delete_id, created_at, updated_at) FROM stdin;
320	1	2	1	E	2	Achievement Orientation	\N	1	0	2022-02-20 14:20:37	2022-02-20 14:20:37
321	1	1	2	A	2	Oriented Programming	\N	1	0	2022-02-20 14:22:14	2022-02-20 14:22:14
\.


--
-- Data for Name: dict_bank_sets_items_scores_sets_grades; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_bank_sets_items_scores_sets_grades (id, dict_bank_sets_items_id, tech_discipline_flag, dict_bank_grades_id, score, flag, delete_id, created_at, updated_at) FROM stdin;
3522	320	0	16	2	1	0	2022-02-20 14:28:54	2022-02-20 14:28:54
3523	320	0	17	2	1	0	2022-02-20 14:28:54	2022-02-20 14:28:54
3524	320	0	18	2	1	0	2022-02-20 14:28:54	2022-02-20 14:28:54
3525	320	0	19	2	1	0	2022-02-20 14:28:54	2022-02-20 14:28:54
3526	320	0	20	2	1	0	2022-02-20 14:28:54	2022-02-20 14:28:54
3527	320	0	21	2	1	0	2022-02-20 14:28:54	2022-02-20 14:28:54
3528	320	0	22	2	1	0	2022-02-20 14:28:54	2022-02-20 14:28:54
3529	320	0	23	2	1	0	2022-02-20 14:28:54	2022-02-20 14:28:54
3530	320	0	24	5	1	0	2022-02-20 14:28:54	2022-02-20 14:28:54
3531	321	0	16	6	1	0	2022-02-20 14:29:04	2022-02-20 14:29:04
3532	321	0	17	6	1	0	2022-02-20 14:29:04	2022-02-20 14:29:04
3533	321	0	18	6	1	0	2022-02-20 14:29:04	2022-02-20 14:29:04
3534	321	0	19	6	1	0	2022-02-20 14:29:04	2022-02-20 14:29:04
3535	321	0	20	6	1	0	2022-02-20 14:29:04	2022-02-20 14:29:04
3536	321	0	21	6	1	0	2022-02-20 14:29:04	2022-02-20 14:29:04
3537	321	0	22	6	1	0	2022-02-20 14:29:04	2022-02-20 14:29:04
3538	321	0	23	6	1	0	2022-02-20 14:29:04	2022-02-20 14:29:04
3539	321	0	24	2	1	0	2022-02-20 14:29:04	2022-02-20 14:29:04
\.


--
-- Data for Name: dict_col_competency_types; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_competency_types (id, name, flag, tech_discipline_flag, delete_id, created_at, updated_at) FROM stdin;
1	Behavioural	1	0	0	\N	\N
2	Functional	1	0	0	\N	\N
3	Generic	1	0	0	\N	\N
4	ICT	1	0	0	\N	\N
5	Language	1	0	0	\N	\N
6	Technical (Discipline)	1	0	0	\N	\N
7	Technical (Generic)	1	0	0	\N	\N
\.


--
-- Data for Name: dict_col_competency_types_scale_lvls; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_competency_types_scale_lvls (id, dict_col_competency_types_id, dict_col_scale_lvls_id, flag, delete_id, created_at, updated_at) FROM stdin;
2	2	2	1	0	\N	\N
4	4	4	1	0	\N	\N
5	5	1	1	0	\N	\N
6	6	2	1	0	\N	\N
7	7	2	1	0	\N	\N
3	3	2	1	0	\N	2021-11-25 04:04:14
1	1	3	1	0	\N	2022-01-12 15:07:03
\.


--
-- Data for Name: dict_col_grades; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_grades (id, dict_col_grades_categories_id, grades_id, flag, delete_id, created_at, updated_at) FROM stdin;
1	1	1	1	0	\N	\N
2	1	2	1	0	\N	\N
3	1	3	1	0	\N	\N
4	1	4	1	0	\N	\N
5	1	5	1	0	\N	\N
6	1	6	1	0	\N	\N
7	1	7	1	0	\N	\N
8	1	8	1	0	\N	\N
9	1	9	1	0	\N	\N
10	2	10	1	0	\N	\N
11	2	11	1	0	\N	\N
12	2	12	1	0	\N	\N
13	2	13	1	0	\N	\N
14	2	14	1	0	\N	\N
15	2	15	1	0	\N	\N
16	2	16	1	0	\N	\N
17	2	17	1	0	\N	\N
18	2	18	1	0	\N	\N
19	2	19	1	0	\N	\N
20	2	20	1	0	\N	\N
21	2	21	1	0	\N	\N
22	2	22	1	0	\N	\N
23	2	23	1	0	\N	\N
24	2	24	1	0	\N	\N
\.


--
-- Data for Name: dict_col_grades_categories; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_grades_categories (id, name, flag, delete_id, created_at, updated_at) FROM stdin;
1	Pengurusan dan Profesional	1	0	\N	\N
2	Kumpulan Pelaksana	1	0	\N	\N
\.


--
-- Data for Name: dict_col_jobgroup_sets; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_jobgroup_sets (id, profiles_id, years_id, jurusan_id, dict_col_grades_categories_id, title_eng, title_mal, desc_eng, desc_mal, ref_id, flag, delete_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: dict_col_jobgroup_sets_items; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_jobgroup_sets_items (id, dict_col_jobgroup_sets_id, dict_col_sets_items_id, flag, delete_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: dict_col_measuring_lvls; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_measuring_lvls (id, name, flag, delete_id, created_at, updated_at) FROM stdin;
1	Corporate Effectiveness	1	0	\N	\N
2	Leadership Effectiveness	1	0	\N	\N
3	Personal Effectiveness	1	0	\N	\N
4	Technical Mastery	1	0	\N	\N
5	Keberkesanan Korporat	1	0	\N	\N
6	Keberkesanan Kepimpinan	1	0	\N	\N
7	Keberkesanan Sahsiah	1	0	\N	\N
8	Kepakaran Teknikal	1	0	\N	\N
\.


--
-- Data for Name: dict_col_scale_lvls; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_scale_lvls (id, name, flag, delete_id, created_at, updated_at) FROM stdin;
1	Scale Language	1	0	\N	\N
2	1-6	1	0	\N	\N
3	Yes/No	1	0	\N	\N
4	Scale ICT	1	0	\N	\N
5	1-10	1	0	2021-12-16 01:25:46	2021-12-16 01:25:46
\.


--
-- Data for Name: dict_col_scale_lvls_sets; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_scale_lvls_sets (id, dict_col_scale_lvls_id, dict_col_scale_lvls_skillsets_id, name, score, flag, delete_id, created_at, updated_at) FROM stdin;
1	1	1	Poor command of the language	0	1	0	\N	\N
2	1	2	Able to read and write reasonably well and appreciate a wide variety of texts as well as those pretinent to professional needs	0	1	0	\N	\N
3	1	3	Able to read and write fluently and accurately in all styles and forms of the language on any subject as well as those pertinent to professional needs	0	1	0	\N	\N
4	1	4	Have mastery of the languagel; near native; ability to read, understand and write extremly difficult of abstract prose, a wide variety of vocabulary, idioms colloquialisms, and slang	0	1	0	\N	\N
5	2	5	You are not trained and have no experience	0	1	0	\N	\N
6	2	2	You are still learning and have had some prior exposure or have basic knowledge or have had some practice. You are able to analyse and interpret information. Supervision is needed. You know where to obtain help	0	1	0	\N	\N
7	2	6	You are able to directly apply techniques and use tools/equipment independently. Supervision is necessary from time to time. You are able to diagnose issues, anticipate problems and provide reasoning. You work with practisioners in a specific skill area	0	1	0	\N	\N
8	2	3	You have substantial experience and are able to supervise others. You demonstrate this skill independently almost all the time. You are able to diagnose issues, anticipate problems and provide reasoning. You work with practicitoners in a specific skill area.	0	1	0	\N	\N
9	2	7	You are a source or reference to others who seek advice in a particular area/field. You are able to develop and mentor others in technique, procedure or process. Able to create best practice in the organisation or in a broader context.	0	1	0	\N	\N
10	2	8	You have the skills to set policies and provide overall direction. 	0	1	0	\N	\N
11	4	9	No knowledge of the software applications	0	1	0	\N	\N
12	4	2	Basic knowledge of software applications; may understand and/or apply some parts of the software applications.	0	1	0	\N	\N
13	4	3	Can understand & apply software applications well	0	1	0	\N	\N
14	4	4	High proficiency in understanding, applying & teaching of software applications	0	1	0	\N	\N
\.


--
-- Data for Name: dict_col_scale_lvls_skillsets; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_scale_lvls_skillsets (id, name, flag, delete_id, created_at, updated_at) FROM stdin;
1	Poor	1	0	\N	\N
2	Basic	1	0	\N	\N
3	Proficient	1	0	\N	\N
4	Mastery	1	0	\N	\N
5	Entry	1	0	\N	\N
6	Competent	1	0	\N	\N
7	Expert	1	0	\N	\N
8	Strategies	1	0	\N	\N
9	None	1	0	\N	\N
\.


--
-- Data for Name: dict_col_scale_lvls_types; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_scale_lvls_types (id, name, flag, delete_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: dict_col_sets_competencies_questions; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_sets_competencies_questions (id, dict_col_sets_items_id, title_eng, title_mal, flag, delete_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: dict_col_sets_items; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.dict_col_sets_items (id, dict_col_measuring_lvls_id, dict_col_competency_types_scale_lvls_id, jurusan_id, dict_col_grades_categories_id, title_eng, title_mal, flag, delete_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: grades; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.grades (id, name, flag, delete_id, created_at, updated_at) FROM stdin;
1	VU4	1	0	\N	\N
2	VU5	1	0	\N	\N
3	VU6	1	0	\N	\N
4	VU7	1	0	\N	\N
5	J54	1	0	\N	\N
6	J52	1	0	\N	\N
7	J48	1	0	\N	\N
8	J44	1	0	\N	\N
9	J41	1	0	\N	\N
10	JA38	1	0	\N	\N
11	J38	1	0	\N	\N
12	JA36	1	0	\N	\N
13	J36	1	0	\N	\N
14	JA30	1	0	\N	\N
15	J30	1	0	\N	\N
16	JA29	1	0	\N	\N
17	J29	1	0	\N	\N
18	JA26	1	0	\N	\N
19	J26	1	0	\N	\N
20	JA22	1	0	\N	\N
21	J22	1	0	\N	\N
22	J19	1	0	\N	\N
23	JA17	1	0	\N	\N
24	J17	1	0	\N	\N
25	F41	1	0	2021-12-16 03:52:49	2021-12-16 07:18:36
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_users_table	1
2	2014_10_12_100000_create_password_resets_table	1
3	2019_08_19_000000_create_failed_jobs_table	1
4	2019_12_14_000001_create_personal_access_tokens_table	1
5	2021_09_18_141218_laratrust_setup_tables	1
6	2021_09_20_022848_create_profiles_table	1
7	2021_09_20_022942_create_profiles_cawangan_logs_table	1
8	2021_09_20_022956_create_profiles_alamat_pejabats_table	1
9	2021_09_20_023006_create_profiles_telefons_table	1
10	2021_09_20_023042_create_years_table	1
11	2021_09_22_033149_create_grades_table	1
12	2021_09_23_023105_create_dict_bank_sets_table	1
13	2021_09_23_023106_create_dict_col_grades_categories_table	1
14	2021_09_23_023107_create_dict_bank_grades_categories_table	1
15	2021_09_23_023107_create_dict_bank_grades_table	1
16	2021_09_23_023107_create_dict_col_grades_table	1
17	2021_09_23_023110_create_dict_col_scale_lvls_table	1
18	2021_09_23_023111_create_dict_bank_scale_lvls_types_table	1
19	2021_09_23_023111_create_dict_col_scale_lvls_types_table	1
20	2021_09_23_023211_create_dict_col_measuring_lvls_table	1
21	2021_09_23_023212_create_dict_bank_measuring_lvls_table	1
22	2021_09_23_023212_create_dict_col_competency_types_table	1
23	2021_09_23_023213_create_dict_bank_competency_types_table	1
24	2021_09_23_023213_create_dict_bank_scale_lvls_table	1
25	2021_09_23_023236_create_dict_bank_competency_types_scale_lvls_table	1
26	2021_09_23_023236_create_dict_col_competency_types_scale_lvls_table	1
27	2021_09_23_023545_create_dict_bank_sets_items_table	1
28	2021_09_23_023545_create_dict_col_sets_items_table	1
29	2021_09_23_023546_create_dict_bank_sets_competencies_questions_table	1
30	2021_09_23_023546_create_dict_col_sets_competencies_questions_table	1
31	2021_09_23_023650_create_dict_bank_sets_items_scores_sets_grades_table	1
32	2021_09_23_023722_create_dict_bank_jobgroup_sets_table	1
33	2021_09_23_023722_create_dict_col_jobgroup_sets_table	1
34	2021_09_23_023736_create_dict_bank_jobgroup_sets_items_table	1
35	2021_09_23_023736_create_dict_col_jobgroup_sets_items_table	1
36	2021_09_23_023804_create_dict_bank_jobgroup_sets_items_scores_sets_grades_table	1
37	2021_09_23_084312_create_dict_bank_scale_lvls_years_skillsets_second_table	1
38	2021_09_23_084313_create_dict_col_scale_lvls_skillsets_table	1
39	2021_09_23_084314_create_dict_bank_scale_lvls_sets_table	1
40	2021_09_23_084315_create_dict_col_scale_lvls_sets_table	1
41	2021_11_19_030607_create_penilaians_table	1
42	2021_11_19_030631_create_penilaians_competencies_table	1
43	2021_11_19_030632_create_penilaians_jawapans_table	1
\.


--
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.password_resets (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: penilaians; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.penilaians (id, profiles_id, dict_bank_sets_id, penyelia_profiles_id, dict_bank_jobgroup_sets_id, status, created_at, updated_at, standard_gred, actual_gred, penyelia_update, profiles_cawangans_logs_id, jurusan_id, dict_bank_grades_categories_id, dict_bank_grades_id) FROM stdin;
138	86	1	\N	\N	0	2022-03-08 17:37:46	2022-03-08 17:37:46	J44	J44	0	88	A	2	23
137	69	1	86	177	2	2022-03-08 17:28:52	2022-03-08 17:38:11	J44	J44	1	71	E	2	23
\.


--
-- Data for Name: penilaians_competencies; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.penilaians_competencies (id, penilaians_id, dict_bank_competency_types_scale_lvls_id, status, created_at, updated_at) FROM stdin;
623	137	2	1	2022-03-08 17:28:52	2022-03-08 17:37:10
629	137	1	1	2022-03-08 17:28:52	2022-03-08 17:37:19
630	138	2	0	2022-03-08 17:37:46	2022-03-08 17:37:46
636	138	1	0	2022-03-08 17:37:46	2022-03-08 17:37:46
\.


--
-- Data for Name: penilaians_competencies_avgs; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.penilaians_competencies_avgs (id, penilaians_competencies_id, score, expected, dev_gap, training, created_at, updated_at, dict_bank_sets_items_id, actual_expected, actual_dev_gap, actual_training) FROM stdin;
1812	623	4	6	-2	Required	2022-03-08 17:37:10	2022-03-08 17:37:10	321	\N	\N	\N
1813	629	1	2	-1	Required	2022-03-08 17:37:19	2022-03-08 17:37:19	320	9	-8	Required
\.


--
-- Data for Name: penilaians_competencies_penyelia_avgs; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.penilaians_competencies_penyelia_avgs (id, penilaians_competencies_id, score, expected, dev_gap, training, created_at, updated_at, dict_bank_sets_items_id, actual_expected, actual_dev_gap, actual_training) FROM stdin;
1639	623	4	6	-2	Required	2022-03-08 17:37:10	2022-03-08 17:38:11	321	\N	-2	Required
1640	629	1	2	-1	Required	2022-03-08 17:37:19	2022-03-08 17:38:11	320	9	-1	Required
\.


--
-- Data for Name: penilaians_jawapans; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.penilaians_jawapans (id, penilaians_competencies_id, dict_bank_competencies_questions_id, dict_bank_sets_items_id, score, created_at, updated_at) FROM stdin;
16904	623	431	321	4	2022-03-08 17:28:52	2022-03-08 17:37:10
16905	629	429	320	0	2022-03-08 17:28:52	2022-03-08 17:37:19
16906	629	430	320	1	2022-03-08 17:28:52	2022-03-08 17:37:19
16907	630	431	321	\N	2022-03-08 17:37:46	2022-03-08 17:37:46
16908	636	429	320	\N	2022-03-08 17:37:46	2022-03-08 17:37:46
16909	636	430	320	\N	2022-03-08 17:37:46	2022-03-08 17:37:46
\.


--
-- Data for Name: permission_role; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.permission_role (permission_id, role_id) FROM stdin;
\.


--
-- Data for Name: permission_user; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.permission_user (permission_id, user_id, user_type) FROM stdin;
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.permissions (id, name, display_name, description, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: profiles; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.profiles (id, users_id, flag, delete_id, created_at, updated_at) FROM stdin;
71	34	1	0	2021-12-29 11:58:56	2021-12-29 11:58:56
72	35	1	0	2021-12-29 15:22:02	2021-12-29 15:22:02
73	36	1	0	2021-12-29 15:22:12	2021-12-29 15:22:12
74	37	1	0	2021-12-29 15:25:48	2021-12-29 15:25:48
75	38	1	0	2021-12-29 15:25:56	2021-12-29 15:25:56
76	39	1	0	2021-12-29 15:27:51	2021-12-29 15:27:51
77	40	1	0	2021-12-29 15:29:32	2021-12-29 15:29:32
78	41	1	0	2021-12-29 15:29:41	2021-12-29 15:29:41
79	42	1	0	2021-12-29 15:31:00	2021-12-29 15:31:00
80	43	1	0	2021-12-29 15:33:35	2021-12-29 15:33:35
81	44	1	0	2021-12-30 16:00:57	2021-12-30 16:00:57
82	45	1	0	2022-01-12 15:03:34	2022-01-12 15:03:34
83	46	1	0	2022-01-12 15:10:45	2022-01-12 15:10:45
69	32	1	0	2021-12-29 11:53:31	2021-12-29 11:53:31
70	33	1	0	2021-12-29 11:53:37	2021-12-29 11:53:37
84	47	1	0	2022-02-08 13:37:35	2022-02-08 13:37:35
85	48	1	0	2022-02-08 15:03:53	2022-02-08 15:03:53
86	49	1	0	2022-03-07 14:48:40	2022-03-07 14:48:40
\.


--
-- Data for Name: profiles_alamat_pejabats; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.profiles_alamat_pejabats (id, profiles_id, alamat, flag, delete_id, created_at, updated_at) FROM stdin;
68	71	Cawangan Arkitek,\r\nBAHAGIAN REKABENTUK BANGUNAN FASILITI KESIHATAN 1 (BRBF K1),\r\nTINGKAT 13, MENARA TUN ISMAIL MOHAMED ALI,\r\nNO25, JALAN RAJA LAUT,\r\n50582 KUALA LUMPUR.	1	0	2021-12-29 11:58:56	2021-12-29 11:58:56
70	73	JABATAN KERJA RAYA JALAN OMAR 85000 SEGAMAT JOHOR	1	0	2021-12-29 15:22:12	2021-12-29 15:22:12
72	75	JABATAN BEKALAN AIR KEMENTERIAN TENAGA, AIR DAN KOMINIKASI  MALAYSIA, ARAS 1 & 4, BLOK E4/5, PARCEL E PUSAT PENTADBIRAN KERAJAAN PERSEKUTUAN 62668 PUTRAJAYA	1	0	2021-12-29 15:25:56	2021-12-29 15:25:56
74	77	JABATAN KERJA RAYA DAERAH BENTONG 28700 BENTONG negeri pahang	1	0	2021-12-29 15:29:32	2021-12-29 15:29:32
76	79	POLITEKNIK PD 	1	0	2021-12-29 15:31:00	2021-12-29 15:31:00
78	81	Unit projek khas zon selatan 2,\nTing 1, PT9966 & pt 9967,\nputra point, phase 2a, \njalan bbn 1/31, bandar baru nilai,\n71800, n sembilan dk	1	0	2021-12-30 16:00:57	2021-12-30 16:00:57
80	83	cawangan DASAR PENGURUSAN KORPERAT\r\nJAWATAN KUMPULAN\r\nARAS 29 BLOK G MENARA KERJA RAYA\r\nJALAN SULTAN SALAHUDDIN\r\n40582 KUALA LUMPUR	1	0	2022-01-12 15:10:45	2022-01-12 15:10:45
69	72	JABATAN PENDIDIKAN NEGERI SARAWAK,\r\nSEKTOR KHIDMAT PENGURUSAN & PEMBANGUNAN,\r\nTKT.3, JLN DIPLOMATIK OFF JLN BAKO,\r\nPETRA JAYA, 93050 KUCHING, SARAWAK.	1	0	2021-12-29 15:22:02	2021-12-29 15:22:02
71	74	CAW. KEJURUTERAAN CERUN TKT. 12, BLOK F, IBU PEJABAT JKR JALAN SULTAN SALAHUDDIN 50582 KUALA LUMPUR	1	0	2021-12-29 15:25:48	2021-12-29 15:25:48
73	76	pejabat jurutera daerah,\njabatan kerja raya daerah muar,\n84000 muar.	1	0	2021-12-29 15:27:51	2021-12-29 15:27:51
75	78	UNIT JKR KESEDAR, IBU PEJABAT KESEDAR, BANDAR BARU GUA MUSANG, 18300 GUA MUSANG, KELANTAN	1	0	2021-12-29 15:29:41	2021-12-29 15:29:41
77	80	PEJABAT PENGARAH KERJA RAYA\r\nNEGERI PAHANG DARUL MAKMUR\r\nTINGKAT 9 - 12, KOMTUR,\r\nBANDAR INDERA MAHKOTA, \r\n25582 KUANTAN	1	0	2021-12-29 15:33:35	2021-12-29 15:33:35
79	82	UNIT KOMPETENSI,\r\nBAHAGIAN PEMBANGUNAN SKIM KEJURUTERAAN,\r\nCAW. DASAR DAN PENGURUSAN KORPORAT,\r\nIBU PEJABAT JKR MALAYSIA	1	0	2022-01-12 15:03:34	2022-01-12 15:03:34
66	69	CAWANGAN DASAR DAN PENGURUSAN KORPORAT,\r\nARAS 30 BLOK G,\r\nIBU PEJABAT JKR MALAYSIA\r\nNO 6 JLN SULTAN SALAHUDDIN,\r\n50480 KUALA LUMPUR	1	0	2021-12-29 11:53:31	2021-12-29 11:53:31
67	70	cAWANGAN kEjURUTERAAN eLEKTRIK\njkr nEGERI sEMBILAN\ntAMAN eNGLAND	1	0	2021-12-29 11:53:37	2021-12-29 11:53:37
81	84	JKR CAWANGAN KEJURUTERAAN ELEKTRIK NEGERI KEDAH, KAWASAN PERUSAHAAN MERGONG, 05582 ALOR SETAR, KEDAH	1	0	2022-02-08 13:37:35	2022-02-08 13:37:35
82	85	PEJABAT PEMBANGUNAN NEGERI SELANGOR ICU JPM, ARAS 1 BANGUNAN PILECON ENG SDN BHD NO.2 JLN U1/26, SEKSYEN U1 40150 SHAH ALAM SELANGOR DARUL EHSAN	1	0	2022-02-08 15:03:53	2022-02-08 15:03:53
83	86	bAHAGIAN siasatan tapak\nCAWANGAN KEJURUTERAAN GEOTEKNIK\nIBU PEJABAT JKR MALAYSIA\nTINGKAT 23A, MENARA PJD,\nNO.50, JALAN TUN RAZAK, 50400 \nKUALA LUMPUR	1	0	2022-03-07 14:48:40	2022-03-07 14:48:40
\.


--
-- Data for Name: profiles_cawangan_logs; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.profiles_cawangan_logs (id, profiles_id, neg_perseketuan, cawangan, sektor, bahagian, unit, penempatan, cawangan_name, sektor_name, bahagian_name, unit_name, penempatan_name, tahun, flag, delete_id, created_at, updated_at, gred, jurusan_id) FROM stdin;
73	71	\N	50200000000	50000000000	50201000000	50201020000	50201020000	Cawangan Arkitek	Sektor Pakar	Bahagian Reka Bentuk 1	Bahagian Reka Bentuk Fasiliti Kesihatan 1	Bahagian Reka Bentuk Fasiliti Kesihatan 1	2021	1	0	2021-12-29 11:58:56	2021-12-29 11:58:56	JA29	\N
76	74	\N	30400000000	30000000000	30400000000	30400000000	30400000000	Cawangan Kejuruteraan Cerun	Sektor Infra	Cawangan Kejuruteraan Cerun	Cawangan Kejuruteraan Cerun	Cawangan Kejuruteraan Cerun	2021	1	0	2021-12-29 15:25:48	2021-12-29 15:25:48	VU7	\N
79	77	\N	80600000000	80000000000	80601000000	80601000000	80601000000	Jabatan Kerja Raya Negeri Pahang	Negeri	JKR Daerah Bentong	JKR Daerah Bentong	JKR Daerah Bentong	2021	1	0	2021-12-29 15:29:32	2021-12-29 15:29:32	J52	\N
82	80	\N	80600000000	80000000000	80612000000	80612100000	80612100000	Jabatan Kerja Raya Negeri Pahang	Negeri	Ibu Pejabat JKR Pahang	Bahagian Bangunan	Bahagian Bangunan	2021	1	0	2021-12-29 15:33:35	2021-12-29 15:33:35	JA36	\N
85	83	\N	20300000000	20000000000	20301000000	20301020000	20301020000	Cawangan Dasar dan Pengurusan Korporat	Pengurusan Operasi Dan Strategik	Bahagian Pembangunan Skim Kejuruteraan	Unit Kompetensi	Unit Kompetensi	2022	1	0	2022-01-12 15:10:45	2022-01-12 15:10:45	J52	\N
74	72	\N	71000000000	70000000000	71000000000	71000000000	71000000000	Kementerian Pendidikan	Lain-lain Kementerian	Kementerian Pendidikan	Kementerian Pendidikan	Kementerian Pendidikan	2021	1	0	2021-12-29 15:22:02	2021-12-29 15:22:02	J44	\N
77	75	\N	72500000000	70000000000	72500000000	72500000000	72500000000	Kementerian Alam Sekitar Dan Air	Lain-lain Kementerian	Kementerian Alam Sekitar Dan Air	Kementerian Alam Sekitar Dan Air	Kementerian Alam Sekitar Dan Air	2021	1	0	2021-12-29 15:25:56	2021-12-29 15:25:56	JA29	\N
80	78	\N	20800000000	20000000000	20808000000	20808000000	20808000000	JKR Lembaga Kemajuan Kelantan Selatan (KESEDAR)	Pengurusan Operasi Dan Strategik	Bahagian Pengurusan/Operasi/Pelaksanaan Projek (Utara)	Bahagian Pengurusan/Operasi/Pelaksanaan Projek (Utara)	Bahagian Pengurusan/Operasi/Pelaksanaan Projek (Utara)	2021	1	0	2021-12-29 15:29:41	2021-12-29 15:29:41	JA29	\N
83	81	\N	30200000000	30000000000	30204000000	30204000000	30204000000	Cawangan Jalan	Sektor Infra	Pengurusan Projek	Pengurusan Projek	Pengurusan Projek	2021	1	0	2021-12-30 16:00:57	2021-12-30 16:00:57	J52	\N
75	73	\N	80100000000	80000000000	80108000000	80108000000	80108000000	Jabatan Kerja Raya Negeri Johor	Negeri	JKR Daerah Segamat	JKR Daerah Segamat	JKR Daerah Segamat	2021	1	0	2021-12-29 15:22:12	2021-12-29 15:22:12	JA29	\N
78	76	\N	80100000000	80000000000	80106000000	80106000000	80106000000	Jabatan Kerja Raya Negeri Johor	Negeri	JKR Daerah Muar	JKR Daerah Muar	JKR Daerah Muar	2021	1	0	2021-12-29 15:27:51	2021-12-29 15:27:51	H19	\N
81	79	\N	71000000000	70000000000	71000000000	71000000000	71000000000	Kementerian Pendidikan	Lain-lain Kementerian	Kementerian Pendidikan	Kementerian Pendidikan	Kementerian Pendidikan	2021	1	0	2021-12-29 15:31:00	2021-12-29 15:31:00	JA29	\N
84	82	\N	20300000000	20000000000	20301000000	20301020000	20301020000	Cawangan Dasar dan Pengurusan Korporat	Pengurusan Operasi Dan Strategik	Bahagian Pembangunan Skim Kejuruteraan	Unit Kompetensi	Unit Kompetensi	2022	1	0	2022-01-12 15:03:34	2022-01-12 15:03:34	J44	\N
71	69	\N	40700000000	40000000000	40700000000	40700000000	40700000000	Cawangan Senggara Fasiliti Bangunan	Sektor Bangunan	Cawangan Senggara Fasiliti Bangunan	Cawangan Senggara Fasiliti Bangunan	Cawangan Senggara Fasiliti Bangunan	2021	1	0	2021-12-29 11:53:31	2021-12-29 11:53:31	J44	\N
72	70	\N	73600000000	70000000000	73612000000	73612020000	73612020000	Kementerian Tenaga dan Sumber Asli	Lain-lain Kementerian	Pasukan Projek Khas Bekalan Elektrik Sabah (PPKBES)	Seksyen Projek (PPKBES Sabah)	Seksyen Projek (PPKBES Sabah)	2021	1	0	2021-12-29 11:53:37	2021-12-29 11:53:37	J54	\N
86	84	\N	80600000000	80000000000	80612000000	80612040000	80612040000	Jabatan Kerja Raya Negeri Pahang	Negeri	Ibu Pejabat JKR Pahang	Bahagian Jalan	Bahagian Jalan	2022	1	0	2022-02-08 13:37:35	2022-02-08 13:37:35	J44	\N
87	85	\N	70100000000	70000000000	70100000000	70100000000	70100000000	Jabatan Perdana Menteri	Lain-lain Kementerian	Jabatan Perdana Menteri	Jabatan Perdana Menteri	Jabatan Perdana Menteri	2022	1	0	2022-02-08 15:03:53	2022-02-08 15:03:53	JA29	\N
88	86	\N	40700000000	40000000000	40708000000	40708000000	40708000000	Cawangan Senggara Fasiliti Bangunan	Sektor Bangunan	Bahagian Fasiliti Bangunan Am 2	Bahagian Fasiliti Bangunan Am 2	Bahagian Fasiliti Bangunan Am 2	2022	1	0	2022-03-07 14:48:40	2022-03-07 14:48:40	J44	\N
\.


--
-- Data for Name: profiles_telefons; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.profiles_telefons (id, profiles_id, no_tel_pejabat, no_tel_bimbit, flag, delete_id, created_at, updated_at) FROM stdin;
68	71	03-26165250	017-3852976	1	0	2021-12-29 11:58:56	2021-12-29 11:58:56
69	72	08-2473688	013-8320089	1	0	2021-12-29 15:22:02	2021-12-29 15:22:02
70	73	07-931404042	019-7708049	1	0	2021-12-29 15:22:12	2021-12-29 15:22:12
71	74	03-27714289	012-3185627	1	0	2021-12-29 15:25:48	2021-12-29 15:25:48
72	75	03-88836025	013-9308335	1	0	2021-12-29 15:25:56	2021-12-29 15:25:56
73	76	06-9521611	017-3293731	1	0	2021-12-29 15:27:51	2021-12-29 15:27:51
74	77	092224040	013-2081298	1	0	2021-12-29 15:29:32	2021-12-29 15:29:32
75	78	09-9121788	019-9939933	1	0	2021-12-29 15:29:41	2021-12-29 15:29:41
76	79	06-6622029	012-6519650	1	0	2021-12-29 15:31:00	2021-12-29 15:31:00
77	80	09-5717000	019-9290669	1	0	2021-12-29 15:33:35	2021-12-29 15:33:35
78	81	03-8925 0510	019-3740496	1	0	2021-12-30 16:00:57	2021-12-30 16:00:57
79	82	03-26188675	019-9676205	1	0	2022-01-12 15:03:34	2022-01-12 15:03:34
80	83	03-26108888	0192267110	1	0	2022-01-12 15:10:45	2022-01-12 15:10:45
66	69	03-26168676	013-9868070	1	0	2021-12-29 11:53:31	2021-12-29 11:53:31
67	70	06-7632845	017-3080434	1	0	2021-12-29 11:53:37	2021-12-29 11:53:37
81	84	04-7408555	012-2936533	1	0	2022-02-08 13:37:35	2022-02-08 13:37:35
82	85	03-78849299	012-6505185	1	0	2022-02-08 15:03:53	2022-02-08 15:03:53
83	86	03-26184631	012-531 2579	1	0	2022-03-07 14:48:40	2022-03-07 14:48:40
\.


--
-- Data for Name: role_user; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.role_user (id, role_id, user_id, user_type) FROM stdin;
1	1	1	App\\Models\\User
4	4	2	App\\Models\\User
5	4	4	App\\Models\\User
10	4	6	App\\Models\\User
11	4	7	App\\Models\\User
12	3	7	App\\Models\\User
15	4	9	App\\Models\\User
16	3	9	App\\Models\\User
17	4	10	App\\Models\\User
18	3	10	App\\Models\\User
19	1	4	App\\Models\\User
20	4	11	App\\Models\\User
21	3	11	App\\Models\\User
22	4	12	App\\Models\\User
24	4	13	App\\Models\\User
25	4	14	App\\Models\\User
26	3	14	App\\Models\\User
27	4	15	App\\Models\\User
28	4	16	App\\Models\\User
29	3	16	App\\Models\\User
30	4	17	App\\Models\\User
31	4	18	App\\Models\\User
33	4	20	App\\Models\\User
35	4	21	App\\Models\\User
36	4	22	App\\Models\\User
37	3	22	App\\Models\\User
38	4	23	App\\Models\\User
39	4	24	App\\Models\\User
41	4	25	App\\Models\\User
42	3	25	App\\Models\\User
3	4	3	App\\Models\\User
44	4	27	App\\Models\\User
46	4	28	App\\Models\\User
47	3	28	App\\Models\\User
32	4	19	App\\Models\\User
48	4	29	App\\Models\\User
49	3	29	App\\Models\\User
50	4	30	App\\Models\\User
51	3	30	App\\Models\\User
13	4	8	App\\Models\\User
14	4	8	App\\Models\\User
43	4	26	App\\Models\\User
53	3	12	App\\Models\\User
6	4	5	App\\Models\\User
54	4	31	App\\Models\\User
55	3	31	App\\Models\\User
56	4	32	App\\Models\\User
57	4	33	App\\Models\\User
58	3	33	App\\Models\\User
59	4	34	App\\Models\\User
60	4	35	App\\Models\\User
61	4	36	App\\Models\\User
62	3	36	App\\Models\\User
63	4	37	App\\Models\\User
64	4	38	App\\Models\\User
65	3	38	App\\Models\\User
66	4	39	App\\Models\\User
67	4	40	App\\Models\\User
68	4	41	App\\Models\\User
69	3	41	App\\Models\\User
70	4	42	App\\Models\\User
71	4	43	App\\Models\\User
72	4	44	App\\Models\\User
73	3	44	App\\Models\\User
74	4	45	App\\Models\\User
75	4	46	App\\Models\\User
76	3	46	App\\Models\\User
77	4	47	App\\Models\\User
78	4	48	App\\Models\\User
79	3	48	App\\Models\\User
80	1	32	App\\Models\\User
81	3	49	App\\Models\\User
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.roles (id, name, display_name, description, created_at, updated_at) FROM stdin;
1	Admin	Admin	Admin User	\N	\N
2	Penyelaras	Penyelaras	Penyelaras User	\N	\N
3	Penyelia	Penyelia	Penyelia User	\N	\N
4	Pengguna	Pengguna	Pengguna User	\N	\N
\.


--
-- Data for Name: soalan; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.soalan (id, soalan, id_sub_tajuk) FROM stdin;
\.


--
-- Data for Name: sub_soalan; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.sub_soalan (id, sub_soalan, id_soalan) FROM stdin;
\.


--
-- Data for Name: sub_sub_soalan; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.sub_sub_soalan (id, sub_sub_soalan, id_sub_soalan) FROM stdin;
\.


--
-- Data for Name: sub_tajuk; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.sub_tajuk (id, sub_tajuk, id_tajuk) FROM stdin;
\.


--
-- Data for Name: tajuk; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.tajuk (id, "Tajuk") FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.users (id, nokp, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
1	111	Admin	admin@admin.com	\N	$2y$10$L85wWYpO3TUx7WrozFqxvOSBlIJ/slPzYXaupRvLGNBUlW5vUNo06	\N	\N	\N
32	830721035784	SYELLY NOORZIANA BINTI ZAKARIA	syelly@jkr.gov.my	\N	$2y$10$q5TICxKFArZUdKaafx3aL./GfYcH9V7v6D8Vu2Zb.b48lXuo2qRRe	\N	2021-12-29 11:53:31	2021-12-29 11:53:31
44	621224107061	ABD MURAD B. ABU BAKAR	abdmuradb@jkr.gov.my	\N	$2y$10$D5MVd0uPaMLfT4PuDPfeYuJrzVhfJlmuZZ7/G35Pdbfg2unNB6qOe	\N	2021-12-30 16:00:57	2021-12-30 16:00:57
45	860528295346	WAN NUR AZIERIN BINTI WAN AZMIN	WNAzierin@jkr.gov.my	\N	$2y$10$NNs/nTw5A73yczzVqv3xrOuIJPPbYdSH3i0t30jzsCSnPbv4nPSce	\N	2022-01-12 15:03:34	2022-01-12 15:03:34
46	780107145032	NORAIN BINTI OSMAN	norainosman@jkr.gov.my	\N	$2y$10$/Ixnw.ZzOpoUyRuMUyJj5eGe8HdY9hahUakzqDWgz.49bkBEDhmym	\N	2022-01-12 15:10:45	2022-01-12 15:10:45
33	751202135577	ABANG ABD RAHMAN B YUSUF	abangabrahman@jkr.gov.my	\N	$2y$10$4y.qXc7w7u2ZoF.IaJb.fOGm5aq2NzWmIs7HXpIK0Nc9HHmrp7MOS	\N	2021-12-29 11:53:37	2021-12-29 11:53:37
34	910312045375	AHMAD AMIRUL BIN ABU BAKAR	a.amirul@jkr.gov.my	\N	$2y$10$UwXsJ3dOxj2ATUuRppoX1ecmJNlWVdp8EHtRlQnv.hxT1D43KiZtG	\N	2021-12-29 11:58:56	2021-12-29 11:58:56
35	830910135346	AGATA ANAK NGAWANG	agatha.ngawang@moe.gov.my	\N	$2y$10$MDMg0tty7uVTOnxTTevMheCk8QWXl1o2MQ1wFvjDWUjQwP.XzNFee	\N	2021-12-29 15:22:02	2021-12-29 15:22:02
36	640102015859	ABD. MALEK BIN SANAT	segamat@jkr.gov.my	\N	$2y$10$/a5I2PT9OHxkL0CBsj7dQO1ao3vpQ4SD0D6vAZ0qL40Z5Wgmk9Mbq	\N	2021-12-29 15:22:12	2021-12-29 15:22:12
37	630101018645	ABD RAHMAN B PANDI	abdrahman.pandi@jkr.gov.my	\N	$2y$10$d/sLpX4xXWQtEd0/IpzZXOVnxb4zcIVHa6jOUZ7f8ZJQhkSD70bN6	\N	2021-12-29 15:25:48	2021-12-29 15:25:48
38	640723015771	ABD. GHAFAR BIN ISMAIL	aghafar@kettha.gov.my	\N	$2y$10$4Igo5LJU3y/Mjyl2rO6Cf.FO0WHLGly8Lg8t1cFnM8DL2Z8LU3kcC	\N	2021-12-29 15:25:56	2021-12-29 15:25:56
39	750524015995	ABD RASHID BIN ABD HAMID	muar@jkr.gov.my	\N	$2y$10$KAqiL7OINs8A6MZUA4Qe2uLXXU7AEe37dv/yCyv4DAHtSARLMUOcS	\N	2021-12-29 15:27:51	2021-12-29 15:27:51
40	710621035465	ADNAN BIN LADIN	adnanl@jkr.gov.my	\N	$2y$10$wKy9KirX3KNgYZiNwLRWG.j7D2dgTlyTeM6rM4dra11x8rjYWjoda	\N	2021-12-29 15:29:32	2021-12-29 15:29:32
41	640125035297	A.RAHIM B YUNUS	reen6391@gmail.com	\N	$2y$10$UhZoWj4ncqb73tqp6rPIauE6R4OO6s7UVJ2RmGLhETZGQoJiQtMo.	\N	2021-12-29 15:29:41	2021-12-29 15:29:41
42	810125055596	AFIZAH BINTI AZALI	afizah@polipd.edu.my	\N	$2y$10$T./USRgv9d45XDc/wdmtwOZ0tKpuAiG5KfNLPwn3NcQ5DwPUFhMoq	\N	2021-12-29 15:31:00	2021-12-29 15:31:00
43	750610035175	AFZANIZAM BIN CHE WILL	neobrembo@gmail.com	\N	$2y$10$XjlWLX1GCVtQ7k.Ctl6DXecF8UhWzlP9b0.M4KRJlYc5kpZXVGCne	\N	2021-12-29 15:33:35	2021-12-29 15:33:35
47	840208086475	ABDUL KADIR BIN ZAKARIA	AbdulKadir@jkr.gov.my	\N	$2y$10$aPpSThY0R3WpA.4FDaZln.ChSkDIzp6DiwsNtjo82r.z8qw4fnrRu	\N	2022-02-08 13:37:35	2022-02-08 13:37:35
48	840713065157	A'FIF BIN SHAHARUDIN	papa_lalat@yahoo.com	\N	$2y$10$rMEYONfTLtBMAaxI6PTIoeS.ahBtmhnKbLdPnUBjScSVgpCPXMvdK	\N	2022-02-08 15:03:53	2022-02-08 15:03:53
49	850424025414	AANISAH BT ABDUL RAHMAN	aanisah@jkr.gov.my	\N	$2y$10$BulnqvD96V9U3WhOgGXixuOPiQSJ4TI7dJZMmLGj7WaOK7Ap3kXS.	\N	2022-03-07 14:48:40	2022-03-07 14:48:40
\.


--
-- Data for Name: years; Type: TABLE DATA; Schema: public; Owner: rookiextreme
--

COPY public.years (id, year, created_at, updated_at) FROM stdin;
1	2021	\N	\N
\.


--
-- Data for Name: edb$session_wait_history; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys."edb$session_wait_history" (edb_id, dbname, backend_id, seq, wait_name, elapsed, p1, p2, p3) FROM stdin;
\.


--
-- Data for Name: edb$session_waits; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys."edb$session_waits" (edb_id, dbname, backend_id, wait_name, wait_count, avg_wait_time, max_wait_time, total_wait_time, usename, query) FROM stdin;
\.


--
-- Data for Name: edb$snap; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys."edb$snap" (edb_id, dbname, snap_tm, start_tm, backend_id, comment, baseline_ind) FROM stdin;
\.


--
-- Data for Name: edb$stat_all_indexes; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys."edb$stat_all_indexes" (edb_id, dbname, relid, indexrelid, schemaname, relname, indexrelname, idx_scan, idx_tup_read, idx_tup_fetch) FROM stdin;
\.


--
-- Data for Name: edb$stat_all_tables; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys."edb$stat_all_tables" (edb_id, dbname, relid, schemaname, relname, seq_scan, seq_tup_read, idx_scan, idx_tup_fetch, n_tup_ins, n_tup_upd, n_tup_del, last_vacuum, last_autovacuum, last_analyze, last_autoanalyze) FROM stdin;
\.


--
-- Data for Name: edb$stat_database; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys."edb$stat_database" (edb_id, dbname, datid, datname, numbackends, xact_commit, xact_rollback, blks_read, blks_hit, blks_icache_hit) FROM stdin;
\.


--
-- Data for Name: edb$statio_all_indexes; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys."edb$statio_all_indexes" (edb_id, dbname, relid, indexrelid, schemaname, relname, indexrelname, idx_blks_read, idx_blks_hit, idx_blks_icache_hit) FROM stdin;
\.


--
-- Data for Name: edb$statio_all_tables; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys."edb$statio_all_tables" (edb_id, dbname, relid, schemaname, relname, heap_blks_read, heap_blks_hit, heap_blks_icache_hit, idx_blks_read, idx_blks_hit, idx_blks_icache_hit, toast_blks_read, toast_blks_hit, toast_blks_icache_hit, tidx_blks_read, tidx_blks_hit, tidx_blks_icache_hit) FROM stdin;
\.


--
-- Data for Name: edb$system_waits; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys."edb$system_waits" (edb_id, dbname, wait_name, wait_count, avg_wait, max_wait, totalwait) FROM stdin;
\.


--
-- Data for Name: plsql_profiler_rawdata; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys.plsql_profiler_rawdata (runid, sourcecode, func_oid, line_number, exec_count, tuples_returned, time_total, time_shortest, time_longest, num_scans, tuples_fetched, tuples_inserted, tuples_updated, tuples_deleted, blocks_fetched, blocks_hit, wal_write, wal_flush, wal_file_sync, buffer_free_list_lock_acquire, shmem_index_lock_acquire, oid_gen_lock_acquire, xid_gen_lock_acquire, proc_array_lock_acquire, sinval_lock_acquire, freespace_lock_acquire, wal_insert_lock_acquire, wal_write_lock_acquire, control_file_lock_acquire, checkpoint_lock_acquire, clog_control_lock_acquire, subtrans_control_lock_acquire, multi_xact_gen_lock_acquire, multi_xact_offset_lock_acquire, multi_xact_member_lock_acquire, rel_cache_init_lock_acquire, bgwriter_communication_lock_acquire, two_phase_state_lock_acquire, tablespace_create_lock_acquire, btree_vacuum_lock_acquire, add_in_shmem_lock_acquire, autovacuum_lock_acquire, autovacuum_schedule_lock_acquire, syncscan_lock_acquire, icache_lock_acquire, breakpoint_lock_acquire, lwlock_acquire, db_file_read, db_file_write, db_file_sync, db_file_extend, sql_parse, query_plan, infinitecache_read, infinitecache_write, wal_write_time, wal_flush_time, wal_file_sync_time, buffer_free_list_lock_acquire_time, shmem_index_lock_acquire_time, oid_gen_lock_acquire_time, xid_gen_lock_acquire_time, proc_array_lock_acquire_time, sinval_lock_acquire_time, freespace_lock_acquire_time, wal_insert_lock_acquire_time, wal_write_lock_acquire_time, control_file_lock_acquire_time, checkpoint_lock_acquire_time, clog_control_lock_acquire_time, subtrans_control_lock_acquire_time, multi_xact_gen_lock_acquire_time, multi_xact_offset_lock_acquire_time, multi_xact_member_lock_acquire_time, rel_cache_init_lock_acquire_time, bgwriter_communication_lock_acquire_time, two_phase_state_lock_acquire_time, tablespace_create_lock_acquire_time, btree_vacuum_lock_acquire_time, add_in_shmem_lock_acquire_time, autovacuum_lock_acquire_time, autovacuum_schedule_lock_acquire_time, syncscan_lock_acquire_time, icache_lock_acquire_time, breakpoint_lock_acquire_time, lwlock_acquire_time, db_file_read_time, db_file_write_time, db_file_sync_time, db_file_extend_time, sql_parse_time, query_plan_time, infinitecache_read_time, infinitecache_write_time, totalwaits, totalwaittime) FROM stdin;
\.


--
-- Data for Name: plsql_profiler_runs; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys.plsql_profiler_runs (runid, related_run, run_owner, run_date, run_comment, run_total_time, run_system_info, run_comment1, spare1) FROM stdin;
\.


--
-- Data for Name: plsql_profiler_units; Type: TABLE DATA; Schema: sys; Owner: rookiextreme
--

COPY sys.plsql_profiler_units (runid, unit_number, unit_type, unit_owner, unit_name, unit_timestamp, total_time, spare1, spare2) FROM stdin;
\.


--
-- Name: dict_bank_competency_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_competency_types_id_seq', 19, true);


--
-- Name: dict_bank_competency_types_scale_lvls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_competency_types_scale_lvls_id_seq', 11, true);


--
-- Name: dict_bank_grades_categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_grades_categories_id_seq', 5, true);


--
-- Name: dict_bank_grades_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_grades_id_seq', 35, true);


--
-- Name: dict_bank_jobgroup_sets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_jobgroup_sets_id_seq', 177, true);


--
-- Name: dict_bank_jobgroup_sets_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_jobgroup_sets_items_id_seq', 2365, true);


--
-- Name: dict_bank_jobgroup_sets_items_scores_sets_grades_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_jobgroup_sets_items_scores_sets_grades_id_seq', 25007, true);


--
-- Name: dict_bank_measuring_lvls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_measuring_lvls_id_seq', 12, true);


--
-- Name: dict_bank_scale_lvls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_scale_lvls_id_seq', 9, true);


--
-- Name: dict_bank_scale_lvls_sets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_scale_lvls_sets_id_seq', 19, true);


--
-- Name: dict_bank_scale_lvls_skillsets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_scale_lvls_skillsets_id_seq', 16, true);


--
-- Name: dict_bank_scale_lvls_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_scale_lvls_types_id_seq', 1, false);


--
-- Name: dict_bank_sets_competencies_questions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_sets_competencies_questions_id_seq', 431, true);


--
-- Name: dict_bank_sets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_sets_id_seq', 7, true);


--
-- Name: dict_bank_sets_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_sets_items_id_seq', 321, true);


--
-- Name: dict_bank_sets_items_scores_sets_grades_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_bank_sets_items_scores_sets_grades_id_seq', 3539, true);


--
-- Name: dict_col_competency_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_competency_types_id_seq', 7, true);


--
-- Name: dict_col_competency_types_scale_lvls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_competency_types_scale_lvls_id_seq', 7, true);


--
-- Name: dict_col_grades_categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_grades_categories_id_seq', 2, true);


--
-- Name: dict_col_grades_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_grades_id_seq', 24, true);


--
-- Name: dict_col_jobgroup_sets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_jobgroup_sets_id_seq', 1, false);


--
-- Name: dict_col_jobgroup_sets_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_jobgroup_sets_items_id_seq', 1, false);


--
-- Name: dict_col_measuring_lvls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_measuring_lvls_id_seq', 8, true);


--
-- Name: dict_col_scale_lvls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_scale_lvls_id_seq', 5, true);


--
-- Name: dict_col_scale_lvls_sets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_scale_lvls_sets_id_seq', 14, true);


--
-- Name: dict_col_scale_lvls_skillsets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_scale_lvls_skillsets_id_seq', 9, true);


--
-- Name: dict_col_scale_lvls_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_scale_lvls_types_id_seq', 1, false);


--
-- Name: dict_col_sets_competencies_questions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_sets_competencies_questions_id_seq', 1, false);


--
-- Name: dict_col_sets_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.dict_col_sets_items_id_seq', 1, false);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: grades_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.grades_id_seq', 25, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.migrations_id_seq', 43, true);


--
-- Name: penilaian_avg_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.penilaian_avg_seq', 1813, true);


--
-- Name: penilaian_penyelia_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.penilaian_penyelia_seq', 1640, true);


--
-- Name: penilaians_competencies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.penilaians_competencies_id_seq', 636, true);


--
-- Name: penilaians_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.penilaians_id_seq', 138, true);


--
-- Name: penilaians_jawapans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.penilaians_jawapans_id_seq', 16909, true);


--
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.permissions_id_seq', 1, false);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: profiles_alamat_pejabats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.profiles_alamat_pejabats_id_seq', 83, true);


--
-- Name: profiles_cawangan_logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.profiles_cawangan_logs_id_seq', 88, true);


--
-- Name: profiles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.profiles_id_seq', 86, true);


--
-- Name: profiles_telefons_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.profiles_telefons_id_seq', 83, true);


--
-- Name: role_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.role_user_id_seq', 81, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.roles_id_seq', 4, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.users_id_seq', 49, true);


--
-- Name: years_id_seq; Type: SEQUENCE SET; Schema: public; Owner: rookiextreme
--

SELECT pg_catalog.setval('public.years_id_seq', 1, true);


--
-- Name: plsql_profiler_runid; Type: SEQUENCE SET; Schema: sys; Owner: rookiextreme
--

SELECT pg_catalog.setval('sys.plsql_profiler_runid', 1, false);


--
-- Name: snapshot_num_seq; Type: SEQUENCE SET; Schema: sys; Owner: rookiextreme
--

SELECT pg_catalog.setval('sys.snapshot_num_seq', 1, false);


--
-- Name: dict_bank_competency_types dict_bank_competency_types_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_competency_types
    ADD CONSTRAINT dict_bank_competency_types_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_competency_types_scale_lvls dict_bank_competency_types_scale_lvls_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_competency_types_scale_lvls
    ADD CONSTRAINT dict_bank_competency_types_scale_lvls_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_grades_categories dict_bank_grades_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_grades_categories
    ADD CONSTRAINT dict_bank_grades_categories_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_grades dict_bank_grades_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_grades
    ADD CONSTRAINT dict_bank_grades_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_jobgroup_sets_items dict_bank_jobgroup_sets_items_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets_items
    ADD CONSTRAINT dict_bank_jobgroup_sets_items_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_jobgroup_sets_items_scores_sets_grades dict_bank_jobgroup_sets_items_scores_sets_grades_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets_items_scores_sets_grades
    ADD CONSTRAINT dict_bank_jobgroup_sets_items_scores_sets_grades_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_jobgroup_sets dict_bank_jobgroup_sets_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets
    ADD CONSTRAINT dict_bank_jobgroup_sets_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_measuring_lvls dict_bank_measuring_lvls_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_measuring_lvls
    ADD CONSTRAINT dict_bank_measuring_lvls_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_scale_lvls dict_bank_scale_lvls_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls
    ADD CONSTRAINT dict_bank_scale_lvls_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_scale_lvls_sets dict_bank_scale_lvls_sets_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls_sets
    ADD CONSTRAINT dict_bank_scale_lvls_sets_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_scale_lvls_skillsets dict_bank_scale_lvls_skillsets_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls_skillsets
    ADD CONSTRAINT dict_bank_scale_lvls_skillsets_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_scale_lvls_types dict_bank_scale_lvls_types_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls_types
    ADD CONSTRAINT dict_bank_scale_lvls_types_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_sets_competencies_questions dict_bank_sets_competencies_questions_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_competencies_questions
    ADD CONSTRAINT dict_bank_sets_competencies_questions_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_sets_items dict_bank_sets_items_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_items
    ADD CONSTRAINT dict_bank_sets_items_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_sets_items_scores_sets_grades dict_bank_sets_items_scores_sets_grades_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_items_scores_sets_grades
    ADD CONSTRAINT dict_bank_sets_items_scores_sets_grades_pkey PRIMARY KEY (id);


--
-- Name: dict_bank_sets dict_bank_sets_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets
    ADD CONSTRAINT dict_bank_sets_pkey PRIMARY KEY (id);


--
-- Name: dict_col_competency_types dict_col_competency_types_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_competency_types
    ADD CONSTRAINT dict_col_competency_types_pkey PRIMARY KEY (id);


--
-- Name: dict_col_competency_types_scale_lvls dict_col_competency_types_scale_lvls_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_competency_types_scale_lvls
    ADD CONSTRAINT dict_col_competency_types_scale_lvls_pkey PRIMARY KEY (id);


--
-- Name: dict_col_grades_categories dict_col_grades_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_grades_categories
    ADD CONSTRAINT dict_col_grades_categories_pkey PRIMARY KEY (id);


--
-- Name: dict_col_grades dict_col_grades_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_grades
    ADD CONSTRAINT dict_col_grades_pkey PRIMARY KEY (id);


--
-- Name: dict_col_jobgroup_sets_items dict_col_jobgroup_sets_items_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_jobgroup_sets_items
    ADD CONSTRAINT dict_col_jobgroup_sets_items_pkey PRIMARY KEY (id);


--
-- Name: dict_col_jobgroup_sets dict_col_jobgroup_sets_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_jobgroup_sets
    ADD CONSTRAINT dict_col_jobgroup_sets_pkey PRIMARY KEY (id);


--
-- Name: dict_col_measuring_lvls dict_col_measuring_lvls_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_measuring_lvls
    ADD CONSTRAINT dict_col_measuring_lvls_pkey PRIMARY KEY (id);


--
-- Name: dict_col_scale_lvls dict_col_scale_lvls_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_scale_lvls
    ADD CONSTRAINT dict_col_scale_lvls_pkey PRIMARY KEY (id);


--
-- Name: dict_col_scale_lvls_sets dict_col_scale_lvls_sets_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_scale_lvls_sets
    ADD CONSTRAINT dict_col_scale_lvls_sets_pkey PRIMARY KEY (id);


--
-- Name: dict_col_scale_lvls_skillsets dict_col_scale_lvls_skillsets_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_scale_lvls_skillsets
    ADD CONSTRAINT dict_col_scale_lvls_skillsets_pkey PRIMARY KEY (id);


--
-- Name: dict_col_scale_lvls_types dict_col_scale_lvls_types_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_scale_lvls_types
    ADD CONSTRAINT dict_col_scale_lvls_types_pkey PRIMARY KEY (id);


--
-- Name: dict_col_sets_competencies_questions dict_col_sets_competencies_questions_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_sets_competencies_questions
    ADD CONSTRAINT dict_col_sets_competencies_questions_pkey PRIMARY KEY (id);


--
-- Name: dict_col_sets_items dict_col_sets_items_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_sets_items
    ADD CONSTRAINT dict_col_sets_items_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: grades grades_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.grades
    ADD CONSTRAINT grades_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: penilaians_competencies_penyelia_avgs penilaians_competencies_avgs_copy1_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies_penyelia_avgs
    ADD CONSTRAINT penilaians_competencies_avgs_copy1_pkey PRIMARY KEY (id);


--
-- Name: penilaians_competencies_avgs penilaians_competencies_avgs_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies_avgs
    ADD CONSTRAINT penilaians_competencies_avgs_pkey PRIMARY KEY (id);


--
-- Name: penilaians_competencies penilaians_competencies_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies
    ADD CONSTRAINT penilaians_competencies_pkey PRIMARY KEY (id);


--
-- Name: penilaians_jawapans penilaians_jawapans_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_jawapans
    ADD CONSTRAINT penilaians_jawapans_pkey PRIMARY KEY (id);


--
-- Name: penilaians penilaians_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians
    ADD CONSTRAINT penilaians_pkey PRIMARY KEY (id);


--
-- Name: permission_role permission_role_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.permission_role
    ADD CONSTRAINT permission_role_pkey PRIMARY KEY (permission_id, role_id);


--
-- Name: permission_user permission_user_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.permission_user
    ADD CONSTRAINT permission_user_pkey PRIMARY KEY (user_id, permission_id, user_type);


--
-- Name: permissions permissions_name_unique; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_unique UNIQUE (name);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: profiles_alamat_pejabats profiles_alamat_pejabats_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles_alamat_pejabats
    ADD CONSTRAINT profiles_alamat_pejabats_pkey PRIMARY KEY (id);


--
-- Name: profiles_cawangan_logs profiles_cawangan_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles_cawangan_logs
    ADD CONSTRAINT profiles_cawangan_logs_pkey PRIMARY KEY (id);


--
-- Name: profiles profiles_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles
    ADD CONSTRAINT profiles_pkey PRIMARY KEY (id);


--
-- Name: profiles_telefons profiles_telefons_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles_telefons
    ADD CONSTRAINT profiles_telefons_pkey PRIMARY KEY (id);


--
-- Name: role_user role_user_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_pkey PRIMARY KEY (id);


--
-- Name: roles roles_name_unique; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_unique UNIQUE (name);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: soalan soalan_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.soalan
    ADD CONSTRAINT soalan_pkey PRIMARY KEY (id);


--
-- Name: sub_soalan sub_soalan_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.sub_soalan
    ADD CONSTRAINT sub_soalan_pkey PRIMARY KEY (id);


--
-- Name: sub_sub_soalan sub_sub_soalan_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.sub_sub_soalan
    ADD CONSTRAINT sub_sub_soalan_pkey PRIMARY KEY (id);


--
-- Name: sub_tajuk sub_tajuk_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.sub_tajuk
    ADD CONSTRAINT sub_tajuk_pkey PRIMARY KEY (id);


--
-- Name: tajuk tajuk_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.tajuk
    ADD CONSTRAINT tajuk_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: years years_pkey; Type: CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.years
    ADD CONSTRAINT years_pkey PRIMARY KEY (id);


--
-- Name: edb$stat_database edb$stat_db_pk; Type: CONSTRAINT; Schema: sys; Owner: rookiextreme
--

ALTER TABLE ONLY sys."edb$stat_database"
    ADD CONSTRAINT "edb$stat_db_pk" PRIMARY KEY (edb_id, dbname, datid);


--
-- Name: edb$stat_all_indexes edb$stat_idx_pk; Type: CONSTRAINT; Schema: sys; Owner: rookiextreme
--

ALTER TABLE ONLY sys."edb$stat_all_indexes"
    ADD CONSTRAINT "edb$stat_idx_pk" PRIMARY KEY (edb_id, dbname, relid, indexrelid);


--
-- Name: edb$stat_all_tables edb$stat_tab_pk; Type: CONSTRAINT; Schema: sys; Owner: rookiextreme
--

ALTER TABLE ONLY sys."edb$stat_all_tables"
    ADD CONSTRAINT "edb$stat_tab_pk" PRIMARY KEY (edb_id, dbname, relid);


--
-- Name: edb$statio_all_indexes edb$statio_idx_pk; Type: CONSTRAINT; Schema: sys; Owner: rookiextreme
--

ALTER TABLE ONLY sys."edb$statio_all_indexes"
    ADD CONSTRAINT "edb$statio_idx_pk" PRIMARY KEY (edb_id, dbname, relid, indexrelid);


--
-- Name: edb$statio_all_tables edb$statio_tab_pk; Type: CONSTRAINT; Schema: sys; Owner: rookiextreme
--

ALTER TABLE ONLY sys."edb$statio_all_tables"
    ADD CONSTRAINT "edb$statio_tab_pk" PRIMARY KEY (edb_id, dbname, relid);


--
-- Name: plsql_profiler_runs plsql_profiler_runs_pkey; Type: CONSTRAINT; Schema: sys; Owner: rookiextreme
--

ALTER TABLE ONLY sys.plsql_profiler_runs
    ADD CONSTRAINT plsql_profiler_runs_pkey PRIMARY KEY (runid);


--
-- Name: edb$session_wait_history session_waits_hist_pk; Type: CONSTRAINT; Schema: sys; Owner: rookiextreme
--

ALTER TABLE ONLY sys."edb$session_wait_history"
    ADD CONSTRAINT session_waits_hist_pk PRIMARY KEY (edb_id, dbname, backend_id, seq);


--
-- Name: edb$session_waits session_waits_pk; Type: CONSTRAINT; Schema: sys; Owner: rookiextreme
--

ALTER TABLE ONLY sys."edb$session_waits"
    ADD CONSTRAINT session_waits_pk PRIMARY KEY (edb_id, dbname, backend_id, wait_name);


--
-- Name: edb$snap snap_pk; Type: CONSTRAINT; Schema: sys; Owner: rookiextreme
--

ALTER TABLE ONLY sys."edb$snap"
    ADD CONSTRAINT snap_pk PRIMARY KEY (edb_id);


--
-- Name: edb$system_waits system_waits_pk; Type: CONSTRAINT; Schema: sys; Owner: rookiextreme
--

ALTER TABLE ONLY sys."edb$system_waits"
    ADD CONSTRAINT system_waits_pk PRIMARY KEY (edb_id, dbname, wait_name);


--
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: rookiextreme
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: rookiextreme
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: soalan_id_key; Type: INDEX; Schema: public; Owner: rookiextreme
--

CREATE UNIQUE INDEX soalan_id_key ON public.soalan USING btree (id);


--
-- Name: sub_soalan_id_key; Type: INDEX; Schema: public; Owner: rookiextreme
--

CREATE UNIQUE INDEX sub_soalan_id_key ON public.sub_soalan USING btree (id);


--
-- Name: sub_tajuk_id_key; Type: INDEX; Schema: public; Owner: rookiextreme
--

CREATE UNIQUE INDEX sub_tajuk_id_key ON public.sub_tajuk USING btree (id);


--
-- Name: tajuk_id_key; Type: INDEX; Schema: public; Owner: rookiextreme
--

CREATE UNIQUE INDEX tajuk_id_key ON public.tajuk USING btree (id);


--
-- Name: dict_bank_competency_types dict_bank_competency_types_dict_bank_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_competency_types
    ADD CONSTRAINT dict_bank_competency_types_dict_bank_sets_id_foreign FOREIGN KEY (dict_bank_sets_id) REFERENCES public.dict_bank_sets(id);


--
-- Name: dict_bank_competency_types dict_bank_competency_types_dict_col_competency_types_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_competency_types
    ADD CONSTRAINT dict_bank_competency_types_dict_col_competency_types_id_foreign FOREIGN KEY (dict_col_competency_types_id) REFERENCES public.dict_col_competency_types(id);


--
-- Name: dict_bank_competency_types_scale_lvls dict_bank_competency_types_scale_lvls_dict_bank_competency_type; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_competency_types_scale_lvls
    ADD CONSTRAINT dict_bank_competency_types_scale_lvls_dict_bank_competency_type FOREIGN KEY (dict_bank_competency_types_id) REFERENCES public.dict_bank_competency_types(id);


--
-- Name: dict_bank_competency_types_scale_lvls dict_bank_competency_types_scale_lvls_dict_bank_scale_lvls_id_f; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_competency_types_scale_lvls
    ADD CONSTRAINT dict_bank_competency_types_scale_lvls_dict_bank_scale_lvls_id_f FOREIGN KEY (dict_bank_scale_lvls_id) REFERENCES public.dict_bank_scale_lvls(id);


--
-- Name: dict_bank_competency_types_scale_lvls dict_bank_competency_types_scale_lvls_dict_bank_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_competency_types_scale_lvls
    ADD CONSTRAINT dict_bank_competency_types_scale_lvls_dict_bank_sets_id_foreign FOREIGN KEY (dict_bank_sets_id) REFERENCES public.dict_bank_sets(id);


--
-- Name: dict_bank_competency_types dict_bank_competency_types_years_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_competency_types
    ADD CONSTRAINT dict_bank_competency_types_years_id_foreign FOREIGN KEY (years_id) REFERENCES public.years(id);


--
-- Name: dict_bank_grades_categories dict_bank_grades_categories_dict_bank_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_grades_categories
    ADD CONSTRAINT dict_bank_grades_categories_dict_bank_sets_id_foreign FOREIGN KEY (dict_bank_sets_id) REFERENCES public.dict_bank_sets(id);


--
-- Name: dict_bank_grades dict_bank_grades_dict_bank_grades_categories_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_grades
    ADD CONSTRAINT dict_bank_grades_dict_bank_grades_categories_id_foreign FOREIGN KEY (dict_bank_grades_categories_id) REFERENCES public.dict_bank_grades_categories(id);


--
-- Name: dict_bank_grades dict_bank_grades_grades_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_grades
    ADD CONSTRAINT dict_bank_grades_grades_id_foreign FOREIGN KEY (grades_id) REFERENCES public.grades(id);


--
-- Name: dict_bank_sets_items dict_bank_grading; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_items
    ADD CONSTRAINT dict_bank_grading FOREIGN KEY (dict_bank_grades_categories_id) REFERENCES public.dict_bank_grades_categories(id);


--
-- Name: dict_bank_jobgroup_sets dict_bank_jobgroup_sets_dict_bank_grades_categories_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets
    ADD CONSTRAINT dict_bank_jobgroup_sets_dict_bank_grades_categories_id_foreign FOREIGN KEY (dict_bank_grades_categories_id) REFERENCES public.dict_bank_grades_categories(id);


--
-- Name: dict_bank_jobgroup_sets dict_bank_jobgroup_sets_dict_bank_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets
    ADD CONSTRAINT dict_bank_jobgroup_sets_dict_bank_sets_id_foreign FOREIGN KEY (dict_bank_sets_id) REFERENCES public.dict_bank_sets(id);


--
-- Name: dict_bank_jobgroup_sets_items dict_bank_jobgroup_sets_items_dict_bank_jobgroup_sets_id_foreig; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets_items
    ADD CONSTRAINT dict_bank_jobgroup_sets_items_dict_bank_jobgroup_sets_id_foreig FOREIGN KEY (dict_bank_jobgroup_sets_id) REFERENCES public.dict_bank_jobgroup_sets(id);


--
-- Name: dict_bank_jobgroup_sets_items dict_bank_jobgroup_sets_items_dict_bank_sets_items_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets_items
    ADD CONSTRAINT dict_bank_jobgroup_sets_items_dict_bank_sets_items_id_foreign FOREIGN KEY (dict_bank_sets_items_id) REFERENCES public.dict_bank_sets_items(id);


--
-- Name: dict_bank_jobgroup_sets_items_scores_sets_grades dict_bank_jobgroup_sets_items_scores_sets_grades_dict_bank_grad; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets_items_scores_sets_grades
    ADD CONSTRAINT dict_bank_jobgroup_sets_items_scores_sets_grades_dict_bank_grad FOREIGN KEY (dict_bank_grades_id) REFERENCES public.dict_bank_grades(id);


--
-- Name: dict_bank_jobgroup_sets_items_scores_sets_grades dict_bank_jobgroup_sets_items_scores_sets_grades_dict_bank_jobg; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets_items_scores_sets_grades
    ADD CONSTRAINT dict_bank_jobgroup_sets_items_scores_sets_grades_dict_bank_jobg FOREIGN KEY (dict_bank_jobgroup_sets_items_id) REFERENCES public.dict_bank_jobgroup_sets_items(id);


--
-- Name: dict_bank_measuring_lvls dict_bank_measuring_lvls_dict_bank_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_measuring_lvls
    ADD CONSTRAINT dict_bank_measuring_lvls_dict_bank_sets_id_foreign FOREIGN KEY (dict_bank_sets_id) REFERENCES public.dict_bank_sets(id);


--
-- Name: dict_bank_measuring_lvls dict_bank_measuring_lvls_dict_col_measuring_lvls_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_measuring_lvls
    ADD CONSTRAINT dict_bank_measuring_lvls_dict_col_measuring_lvls_id_foreign FOREIGN KEY (dict_col_measuring_lvls_id) REFERENCES public.dict_col_measuring_lvls(id);


--
-- Name: dict_bank_scale_lvls dict_bank_scale_lvls_dict_bank_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls
    ADD CONSTRAINT dict_bank_scale_lvls_dict_bank_sets_id_foreign FOREIGN KEY (dict_bank_sets_id) REFERENCES public.dict_bank_sets(id);


--
-- Name: dict_bank_scale_lvls_sets dict_bank_scale_lvls_sets_dict_bank_scale_lvls_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls_sets
    ADD CONSTRAINT dict_bank_scale_lvls_sets_dict_bank_scale_lvls_id_foreign FOREIGN KEY (dict_bank_scale_lvls_id) REFERENCES public.dict_bank_scale_lvls(id);


--
-- Name: dict_bank_scale_lvls_sets dict_bank_scale_lvls_sets_dict_bank_scale_lvls_skillsets_id_for; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls_sets
    ADD CONSTRAINT dict_bank_scale_lvls_sets_dict_bank_scale_lvls_skillsets_id_for FOREIGN KEY (dict_bank_scale_lvls_skillsets_id) REFERENCES public.dict_bank_scale_lvls_skillsets(id);


--
-- Name: dict_bank_scale_lvls_sets dict_bank_scale_lvls_sets_dict_bank_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls_sets
    ADD CONSTRAINT dict_bank_scale_lvls_sets_dict_bank_sets_id_foreign FOREIGN KEY (dict_bank_sets_id) REFERENCES public.dict_bank_sets(id);


--
-- Name: dict_bank_scale_lvls_skillsets dict_bank_scale_lvls_skillsets_dict_bank_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls_skillsets
    ADD CONSTRAINT dict_bank_scale_lvls_skillsets_dict_bank_sets_id_foreign FOREIGN KEY (dict_bank_sets_id) REFERENCES public.dict_bank_sets(id);


--
-- Name: dict_bank_scale_lvls_types dict_bank_scale_lvls_types_dict_bank_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls_types
    ADD CONSTRAINT dict_bank_scale_lvls_types_dict_bank_sets_id_foreign FOREIGN KEY (dict_bank_sets_id) REFERENCES public.dict_bank_sets(id);


--
-- Name: dict_bank_scale_lvls dict_bank_scale_lvls_years_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_scale_lvls
    ADD CONSTRAINT dict_bank_scale_lvls_years_id_foreign FOREIGN KEY (years_id) REFERENCES public.years(id);


--
-- Name: dict_bank_sets_competencies_questions dict_bank_sets_competencies_questions_dict_bank_sets_items_id_f; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_competencies_questions
    ADD CONSTRAINT dict_bank_sets_competencies_questions_dict_bank_sets_items_id_f FOREIGN KEY (dict_bank_sets_items_id) REFERENCES public.dict_bank_sets_items(id);


--
-- Name: dict_bank_sets_items dict_bank_sets_items_dict_bank_competency_types_scale_lvls_id_f; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_items
    ADD CONSTRAINT dict_bank_sets_items_dict_bank_competency_types_scale_lvls_id_f FOREIGN KEY (dict_bank_competency_types_scale_lvls_id) REFERENCES public.dict_bank_competency_types_scale_lvls(id);


--
-- Name: dict_bank_sets_items dict_bank_sets_items_dict_bank_measuring_lvls_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_items
    ADD CONSTRAINT dict_bank_sets_items_dict_bank_measuring_lvls_id_foreign FOREIGN KEY (dict_bank_measuring_lvls_id) REFERENCES public.dict_bank_measuring_lvls(id);


--
-- Name: dict_bank_sets_items dict_bank_sets_items_dict_bank_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_items
    ADD CONSTRAINT dict_bank_sets_items_dict_bank_sets_id_foreign FOREIGN KEY (dict_bank_sets_id) REFERENCES public.dict_bank_sets(id);


--
-- Name: dict_bank_sets_items_scores_sets_grades dict_bank_sets_items_scores_sets_grades_dict_bank_grades_id_for; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_items_scores_sets_grades
    ADD CONSTRAINT dict_bank_sets_items_scores_sets_grades_dict_bank_grades_id_for FOREIGN KEY (dict_bank_grades_id) REFERENCES public.dict_bank_grades(id);


--
-- Name: dict_bank_sets_items_scores_sets_grades dict_bank_sets_items_scores_sets_grades_dict_bank_sets_items_id; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets_items_scores_sets_grades
    ADD CONSTRAINT dict_bank_sets_items_scores_sets_grades_dict_bank_sets_items_id FOREIGN KEY (dict_bank_sets_items_id) REFERENCES public.dict_bank_sets_items(id);


--
-- Name: dict_bank_sets dict_bank_sets_profiles_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets
    ADD CONSTRAINT dict_bank_sets_profiles_id_foreign FOREIGN KEY (profiles_id) REFERENCES public.profiles(id);


--
-- Name: dict_bank_sets dict_bank_sets_years_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_sets
    ADD CONSTRAINT dict_bank_sets_years_id_foreign FOREIGN KEY (years_id) REFERENCES public.years(id);


--
-- Name: dict_col_competency_types_scale_lvls dict_col_competency_types_scale_lvls_dict_col_competency_types_; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_competency_types_scale_lvls
    ADD CONSTRAINT dict_col_competency_types_scale_lvls_dict_col_competency_types_ FOREIGN KEY (dict_col_competency_types_id) REFERENCES public.dict_col_competency_types(id);


--
-- Name: dict_col_competency_types_scale_lvls dict_col_competency_types_scale_lvls_dict_col_scale_lvls_id_for; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_competency_types_scale_lvls
    ADD CONSTRAINT dict_col_competency_types_scale_lvls_dict_col_scale_lvls_id_for FOREIGN KEY (dict_col_scale_lvls_id) REFERENCES public.dict_col_scale_lvls(id);


--
-- Name: dict_col_grades dict_col_grades_dict_col_grades_categories_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_grades
    ADD CONSTRAINT dict_col_grades_dict_col_grades_categories_id_foreign FOREIGN KEY (dict_col_grades_categories_id) REFERENCES public.dict_col_grades_categories(id);


--
-- Name: dict_col_grades dict_col_grades_grades_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_grades
    ADD CONSTRAINT dict_col_grades_grades_id_foreign FOREIGN KEY (grades_id) REFERENCES public.grades(id);


--
-- Name: dict_col_sets_items dict_col_grading; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_sets_items
    ADD CONSTRAINT dict_col_grading FOREIGN KEY (dict_col_grades_categories_id) REFERENCES public.dict_col_grades_categories(id);


--
-- Name: dict_col_jobgroup_sets dict_col_jobgroup_sets_dict_col_grades_categories_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_jobgroup_sets
    ADD CONSTRAINT dict_col_jobgroup_sets_dict_col_grades_categories_id_foreign FOREIGN KEY (dict_col_grades_categories_id) REFERENCES public.dict_col_grades_categories(id);


--
-- Name: dict_col_jobgroup_sets_items dict_col_jobgroup_sets_items_dict_col_jobgroup_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_jobgroup_sets_items
    ADD CONSTRAINT dict_col_jobgroup_sets_items_dict_col_jobgroup_sets_id_foreign FOREIGN KEY (dict_col_jobgroup_sets_id) REFERENCES public.dict_col_jobgroup_sets(id);


--
-- Name: dict_col_jobgroup_sets_items dict_col_jobgroup_sets_items_dict_col_sets_items_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_jobgroup_sets_items
    ADD CONSTRAINT dict_col_jobgroup_sets_items_dict_col_sets_items_id_foreign FOREIGN KEY (dict_col_sets_items_id) REFERENCES public.dict_col_sets_items(id);


--
-- Name: dict_col_jobgroup_sets dict_col_jobgroup_sets_profiles_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_jobgroup_sets
    ADD CONSTRAINT dict_col_jobgroup_sets_profiles_id_foreign FOREIGN KEY (profiles_id) REFERENCES public.profiles(id);


--
-- Name: dict_col_jobgroup_sets dict_col_jobgroup_sets_years_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_jobgroup_sets
    ADD CONSTRAINT dict_col_jobgroup_sets_years_id_foreign FOREIGN KEY (years_id) REFERENCES public.years(id);


--
-- Name: dict_col_scale_lvls_sets dict_col_scale_lvls_sets_dict_col_scale_lvls_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_scale_lvls_sets
    ADD CONSTRAINT dict_col_scale_lvls_sets_dict_col_scale_lvls_id_foreign FOREIGN KEY (dict_col_scale_lvls_id) REFERENCES public.dict_col_scale_lvls(id);


--
-- Name: dict_col_scale_lvls_sets dict_col_scale_lvls_sets_dict_col_scale_lvls_skillsets_id_forei; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_scale_lvls_sets
    ADD CONSTRAINT dict_col_scale_lvls_sets_dict_col_scale_lvls_skillsets_id_forei FOREIGN KEY (dict_col_scale_lvls_skillsets_id) REFERENCES public.dict_col_scale_lvls_skillsets(id);


--
-- Name: dict_col_sets_competencies_questions dict_col_sets_competencies_questions_dict_col_sets_items_id_for; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_sets_competencies_questions
    ADD CONSTRAINT dict_col_sets_competencies_questions_dict_col_sets_items_id_for FOREIGN KEY (dict_col_sets_items_id) REFERENCES public.dict_col_sets_items(id);


--
-- Name: dict_col_sets_items dict_col_sets_items_dict_col_competency_types_scale_lvls_id_for; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_sets_items
    ADD CONSTRAINT dict_col_sets_items_dict_col_competency_types_scale_lvls_id_for FOREIGN KEY (dict_col_competency_types_scale_lvls_id) REFERENCES public.dict_col_competency_types_scale_lvls(id);


--
-- Name: dict_col_sets_items dict_col_sets_items_dict_col_measuring_lvls_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_col_sets_items
    ADD CONSTRAINT dict_col_sets_items_dict_col_measuring_lvls_id_foreign FOREIGN KEY (dict_col_measuring_lvls_id) REFERENCES public.dict_col_measuring_lvls(id);


--
-- Name: sub_soalan fkey_soalan; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.sub_soalan
    ADD CONSTRAINT fkey_soalan FOREIGN KEY (id_soalan) REFERENCES public.soalan(id);


--
-- Name: sub_sub_soalan fkey_sub_soalan; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.sub_sub_soalan
    ADD CONSTRAINT fkey_sub_soalan FOREIGN KEY (id_sub_soalan) REFERENCES public.sub_soalan(id);


--
-- Name: soalan fkey_sub_tajuk; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.soalan
    ADD CONSTRAINT fkey_sub_tajuk FOREIGN KEY (id_sub_tajuk) REFERENCES public.sub_tajuk(id);


--
-- Name: sub_tajuk fkey_tajuk; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.sub_tajuk
    ADD CONSTRAINT fkey_tajuk FOREIGN KEY (id_tajuk) REFERENCES public.tajuk(id);


--
-- Name: dict_bank_jobgroup_sets_items_scores_sets_grades jg_set; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.dict_bank_jobgroup_sets_items_scores_sets_grades
    ADD CONSTRAINT jg_set FOREIGN KEY (dict_bank_jobgroup_sets_id) REFERENCES public.dict_bank_jobgroup_sets(id);


--
-- Name: penilaians penilaians_cawangans_logs; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians
    ADD CONSTRAINT penilaians_cawangans_logs FOREIGN KEY (profiles_cawangans_logs_id) REFERENCES public.profiles_cawangan_logs(id);


--
-- Name: penilaians_competencies_avgs penilaians_competencies_avg_penilaians_competencies_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies_avgs
    ADD CONSTRAINT penilaians_competencies_avg_penilaians_competencies_id_fk FOREIGN KEY (penilaians_competencies_id) REFERENCES public.penilaians_competencies(id);


--
-- Name: penilaians_competencies_penyelia_avgs penilaians_competencies_avgs_co_penilaians_competencies_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies_penyelia_avgs
    ADD CONSTRAINT penilaians_competencies_avgs_co_penilaians_competencies_id_fkey FOREIGN KEY (penilaians_competencies_id) REFERENCES public.penilaians_competencies(id);


--
-- Name: penilaians_competencies_penyelia_avgs penilaians_competencies_avgs_copy1_dict_bank_sets_items_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies_penyelia_avgs
    ADD CONSTRAINT penilaians_competencies_avgs_copy1_dict_bank_sets_items_id_fkey FOREIGN KEY (dict_bank_sets_items_id) REFERENCES public.dict_bank_sets_items(id);


--
-- Name: penilaians_competencies_avgs penilaians_competencies_avgs_dict_bank_sets_items_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies_avgs
    ADD CONSTRAINT penilaians_competencies_avgs_dict_bank_sets_items_id_fk FOREIGN KEY (dict_bank_sets_items_id) REFERENCES public.dict_bank_sets_items(id);


--
-- Name: penilaians_competencies penilaians_competencies_dict_bank_competency_types_scale_lvls_i; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies
    ADD CONSTRAINT penilaians_competencies_dict_bank_competency_types_scale_lvls_i FOREIGN KEY (dict_bank_competency_types_scale_lvls_id) REFERENCES public.dict_bank_competency_types_scale_lvls(id);


--
-- Name: penilaians_competencies penilaians_competencies_penilaians_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_competencies
    ADD CONSTRAINT penilaians_competencies_penilaians_id_foreign FOREIGN KEY (penilaians_id) REFERENCES public.penilaians(id);


--
-- Name: penilaians penilaians_dict_bank_grades; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians
    ADD CONSTRAINT penilaians_dict_bank_grades FOREIGN KEY (dict_bank_grades_id) REFERENCES public.dict_bank_grades(id);


--
-- Name: penilaians penilaians_dict_bank_grades_categories; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians
    ADD CONSTRAINT penilaians_dict_bank_grades_categories FOREIGN KEY (dict_bank_grades_categories_id) REFERENCES public.dict_bank_grades_categories(id);


--
-- Name: penilaians penilaians_dict_bank_jobgroup_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians
    ADD CONSTRAINT penilaians_dict_bank_jobgroup_sets_id_foreign FOREIGN KEY (dict_bank_jobgroup_sets_id) REFERENCES public.dict_bank_jobgroup_sets(id);


--
-- Name: penilaians penilaians_dict_bank_sets_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians
    ADD CONSTRAINT penilaians_dict_bank_sets_id_foreign FOREIGN KEY (dict_bank_sets_id) REFERENCES public.dict_bank_sets(id);


--
-- Name: penilaians_jawapans penilaians_jawapans_dict_bank_competencies_questions_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_jawapans
    ADD CONSTRAINT penilaians_jawapans_dict_bank_competencies_questions_id_foreign FOREIGN KEY (dict_bank_competencies_questions_id) REFERENCES public.dict_bank_sets_competencies_questions(id);


--
-- Name: penilaians_jawapans penilaians_jawapans_dict_bank_sets_items_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_jawapans
    ADD CONSTRAINT penilaians_jawapans_dict_bank_sets_items_id_foreign FOREIGN KEY (dict_bank_sets_items_id) REFERENCES public.dict_bank_sets_items(id);


--
-- Name: penilaians_jawapans penilaians_jawapans_penilaians_competencies_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians_jawapans
    ADD CONSTRAINT penilaians_jawapans_penilaians_competencies_id_foreign FOREIGN KEY (penilaians_competencies_id) REFERENCES public.penilaians_competencies(id);


--
-- Name: penilaians penilaians_penyelia_profiles_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians
    ADD CONSTRAINT penilaians_penyelia_profiles_id_foreign FOREIGN KEY (penyelia_profiles_id) REFERENCES public.profiles(id);


--
-- Name: penilaians penilaians_profiles_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.penilaians
    ADD CONSTRAINT penilaians_profiles_id_foreign FOREIGN KEY (profiles_id) REFERENCES public.profiles(id);


--
-- Name: permission_role permission_role_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.permission_role
    ADD CONSTRAINT permission_role_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: permission_role permission_role_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.permission_role
    ADD CONSTRAINT permission_role_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: permission_user permission_user_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.permission_user
    ADD CONSTRAINT permission_user_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: profiles_alamat_pejabats profiles_alamat_pejabats_profiles_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles_alamat_pejabats
    ADD CONSTRAINT profiles_alamat_pejabats_profiles_id_foreign FOREIGN KEY (profiles_id) REFERENCES public.profiles(id);


--
-- Name: profiles_cawangan_logs profiles_cawangan_logs_profiles_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles_cawangan_logs
    ADD CONSTRAINT profiles_cawangan_logs_profiles_id_foreign FOREIGN KEY (profiles_id) REFERENCES public.profiles(id);


--
-- Name: profiles_telefons profiles_telefons_profiles_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles_telefons
    ADD CONSTRAINT profiles_telefons_profiles_id_foreign FOREIGN KEY (profiles_id) REFERENCES public.profiles(id);


--
-- Name: profiles profiles_users_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.profiles
    ADD CONSTRAINT profiles_users_id_foreign FOREIGN KEY (users_id) REFERENCES public.users(id);


--
-- Name: role_user role_user_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: rookiextreme
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

