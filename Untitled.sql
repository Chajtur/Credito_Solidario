Begin

if new.designation_item_id in ("14","13","17") then

select idDepartamento, idMunicipio into @iddepto, @idmunic from credito_solidario.agencia
where nombre = new.agencia;

select nombre into @departamento from credito_solidario.departamento 
where iddepartamento = @iddepto;
select nombre into @municipio from credito_solidario.municipio
where idMunicipio = @idmunic and idDepartamento =  @iddepto;

insert into credito_solidario.gsc (id, nombre, usuario, clave, tipoEmpleado, parent, agencia, departamento, municipio)
values (new.employee_id, concat(new.first_name, " ", new.last_name), new.username, 
new.password, if(new.designation_item_id = "14", "Gestor", if(new.designation_item_id = "13", "Supervisor", "Coordinador")), 
new.coordinador, new.agencia, @departamento, @municipio)
on duplicate key update id = new.employee_id, nombre = concat(new.first_name, " ", new.last_name), usuario =username , 
clave = password, tipoEmplzeado = if(new.designation_item_id = "14", "Gestor", if(new.designation_item_id = "13", "Supervisor", "Coordinador")), 
parent = new.coordinador, agencia = new.agencia, departamento = @departamento, municipio = @municipio;

end if;

End
